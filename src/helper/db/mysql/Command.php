<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/2
 * Time: 14:44
 */

namespace dmp\helper\db\mysql;

use dmp\base\BaseObject;
use PDO;

class Command extends BaseObject
{

    /**
     * @var Connection
     */
    public $db;

    /**
     * @var \PDOStatement
     */
    public $pdoStatement;

    public $fetchMode = PDO::FETCH_ASSOC;
    public $sql;
    public $params = [];

    private static $transformType = [
        'TINY' => 'intval',
        'SHORT' => 'intval',
        'INT24' => 'intval',
        'LONG' => 'intval',
        'BIT' => 'intval',
        'LONGLONG' => 'intval',
        'DOUBLE' => 'doubleval',
        'FLOAT' => 'floatval',
        'NEWDECIMAL' => 'doubleval'
    ];

    public function init()
    {
        parent::init();
    }


    private function prepare()
    {
        if (empty($this->sql)) {
            return;
        }
        $pdo = $this->db->getPDO();
        $this->pdoStatement = $pdo->prepare($this->sql);
    }

    protected function queryInternal($method, $fetchMode = null)
    {
        $this->_execute();
        $result = call_user_func_array([$this->pdoStatement, $method], ['mode' => $fetchMode === null ? PDO::FETCH_ASSOC : $fetchMode]);
        return $result;
    }

    protected function bindPendingParams()
    {
        if ($this->pdoStatement == null || empty($this->params)) {
            return;
        }
        foreach ($this->params as $name => $value) {
            $this->pdoStatement->bindValue($name, $value, $this->getPdoType($value));
        }
    }

    public function queryOne($fetchMode = null)
    {
        $this->safeBuildLimit(0, 1);
        return $this->transformResult($this->queryInternal('fetch', $fetchMode));
    }

    public function queryAll($fetchMode = null)
    {
        return $this->transformResult($this->queryInternal('fetchAll', $fetchMode), false);
    }

    public function queryScalar()
    {
        $this->safeBuildLimit(0, 1);
        $result = $this->queryInternal('fetchColumn', 0);
        if (is_resource($result) && get_resource_type($result) === 'stream') {
            return stream_get_contents($result);
        } else {
            return $result;
        }
    }

    private function _execute()
    {
        $this->prepare();
        $this->bindPendingParams();
        $this->pdoStatement->execute();
    }

    public function execute()
    {
        $this->_execute();
        return $this->pdoStatement->rowCount();
    }

    private function safeBuildLimit($offset, $row)
    {
        $trimPattern = '/(^\s*)|(\s*$)/';
        $this->sql = rtrim(preg_replace($trimPattern, '', $this->sql), ';');
        preg_match("/(\blimit\b)/i", $this->sql, $match);
        if (empty($match)) {
            $this->buildLimit($offset, $row);
            return;
        }
        $tmpSql = preg_replace($trimPattern, '', substr($this->sql, strripos($this->sql, 'limit') + 5));
        if (strpos($tmpSql, ')') == false) {
            return;
        }
        $this->buildLimit($offset, $row);
    }

    public function buildLimit($offset, $row)
    {
        $this->sql .= ' LIMIT :lmt_offset,:lmt_row ';
        $this->params[':lmt_offset'] = $offset;
        $this->params[':lmt_row'] = $row;
    }

    public function getPdoType($data)
    {
        static $typeMap = [
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'string' => PDO::PARAM_STR,
            'resource' => PDO::PARAM_LOB,
            'NULL' => PDO::PARAM_NULL,
        ];
        $type = gettype($data);
        return isset($typeMap[$type]) ? $typeMap[$type] : PDO::PARAM_STR;
    }

    private function transformResult($res, $oneDim = true)
    {
        if (!is_array($res) || count($res) == 0) {
            return $res;
        }
        $transformColumnType = $this->getTransformColumnType();
        if (count($transformColumnType) == 0) {
            return $res;
        }
        if ($oneDim) {
            $data = [&$res];
        } else {
            $data = &$res;
        }
        foreach ($data as &$item) {
            foreach ($item as $name => &$value) {
                if (!isset($transformColumnType[$name])) {
                    continue;
                }
                $this->transformData($transformColumnType[$name], $value);
            }
        }
        return $res;
    }

    private function transformData($columnType, &$value)
    {
        if (!isset(self::$transformType[$columnType])) {
            return;
        }
        $transformFunc = self::$transformType[$columnType];
        $value = $transformFunc($value);
    }

    private function getTransformColumnType()
    {
        $transformColumnType = [];
        $columnCount = $this->pdoStatement->columnCount();
        for ($i = 0; $i < $columnCount; $i++) {
            $meta = $this->pdoStatement->getColumnMeta($i);
            $nativeType = $meta['native_type'];
            if (isset(self::$transformType[$nativeType])) {
                $transformColumnType[$meta['name']] = $nativeType;
            }
        }
        return $transformColumnType;
    }

    public function __destruct()
    {
        if ($this->pdoStatement != null) {
            $this->pdoStatement = null;
        }
    }
}
