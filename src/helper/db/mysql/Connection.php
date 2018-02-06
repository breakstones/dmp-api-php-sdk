<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/2
 * Time: 10:28
 */

namespace dmp\helper\db\mysql;

use dmp\base\Object;
use PDO;

class Connection extends Object
{
    protected $host = '';
    protected $port = 3306;
    protected $db = '';
    protected $user = '';
    protected $password = '';
    protected $charset = 'utf8';
    protected $connectTimeout = 1;

    /**
     * @var PDO
     */
    public $pdo;

    public function open()
    {
        if ($this->pdo !== null) {
            return;
        }
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset};";;
        $this->pdo = new PDO($dsn, $this->user, $this->password, [PDO::ATTR_PERSISTENT => true]);
        $this->pdo->setAttribute(PDO::ATTR_TIMEOUT, $this->connectTimeout);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('SET NAMES ' . $this->pdo->quote($this->charset));
    }

    public function getPDO()
    {
        $this->open();
        return $this->pdo;
    }


    public function close()
    {
        if ($this->pdo != null) {
            $this->pdo = null;
        }
    }

    public function createCommand($sql, $params = [])
    {
        return new Command(['db' => $this, 'sql' => $sql, 'params' => $params]);
    }
}
