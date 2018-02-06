<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/2
 * Time: 19:00
 */

namespace dmp\helper\db\mysql;


use dmp\base\Object;

class ColumnMeta extends Object
{
    public $native_type;
    public $pdo_type;
    public $lags;
    public $table;
    public $name;
    public $len;
    public $precision;

    static $typeMap = [
        'STRING' => 'char',
        'VAR_STRING' => 'varchar',
        'TINY' => 'tinyint',
        'SHORT' => 'smallint',
        'INT24' => 'mediumint',
        'LONG' => 'int',
        'LONGLONG' => 'bigint',
        'BIT' => 'bit',
        'DOUBLE' => 'double',
        'FLOAT' => 'float',
        'NEWDECIMAL' => 'decimal',
        'DATE' => 'date',
        'DATETIME' => 'datetime',
        'TIMESTAMP' => 'timestamp',
        'BLOB' => 'blob'
    ];

    public function getCharLength()
    {
        return $this->len / 3;
    }

    public function getColumnType()
    {
        switch ($this->native_type) {
            case 'STRING':
                if ($this->len % 3 > 0) {
                    return "binary({$this->len})";
                }
                return "char({$this->getCharLength()})";
            case 'VAR_STRING':
                if ($this->len % 3 > 0) {
                    return "varbinary({$this->len})";
                }
                return "varchar({$this->getCharLength()})";
            case 'TINY':
                return "tinyint({$this->len})";
            case 'SHORT':
                return "smallint({$this->len})";
            case'INT24':
                return "mediumint({$this->len})";
            case 'NEWDECIMAL':
                $len = $this->len - ($this->precision > 0 ? 2 : 1);
                return "decimal({$len},{$this->precision})";
            case 'LONG':
                return "int({$this->len})";
            case 'LONGLONG':
                return "bigint({$this->len})";
            case 'BIT':
                return "bit({$this->len})";
            case 'YEAR':
                return "year({$this->len})";
            case 'DOUBLE':
            case 'FLOAT':
            case 'DATE':
            case 'DATETIME':
            case 'TIMESTAMP':
            case 'TIME':
            case 'GEOMETRY':
                return strtolower($this->native_type);
            case 'BLOB':
                return $this->getBlobColumnType($this->len);
            default:
                return 'Unkown';
        }
    }

    protected function getBlobColumnType($len)
    {
        switch ($len) {
            case -1:
                return 'longtext';
            case 765:
                return 'tinytext';
            case 255:
                return 'tinyblob';
            case 196605:
                return 'text';
            case 16777215:
                return 'mediumblob';
            case 50331645:
                return 'mediumtext';
            default:
                return 'blob';
        }
    }
}
