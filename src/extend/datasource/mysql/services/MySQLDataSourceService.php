<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 19:35
 */

namespace dmp\extend\datasource\mysql\services;


use dmp\extend\datasource\base\interfaces\DataSourceInterface;
use dmp\extend\datasource\base\models\data\DataQueryBuilder;
use dmp\extend\datasource\base\models\QueryBuilderBase;
use dmp\extend\datasource\base\models\struct\BizParameterQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectStructQueryBuilder;
use dmp\helper\db\mysql\Connection;

class MySQLDataSourceService implements DataSourceInterface
{
    /**
     * 获取业务参数值
     * @param BizParameterQueryBuilder $builder
     * @return mixed
     */
    public function getBizParamValue(BizParameterQueryBuilder $builder)
    {
        return '';
    }

    /**
     * 获取对象
     * @param ObjectQueryBuilder $builder
     * @return array
     */
    public function getObjects(ObjectQueryBuilder $builder)
    {
        $db = $this->getDataSource($builder);
        $sql = 'SELECT SQL_CALC_FOUND_ROWS TABLE_NAME AS `name`,TABLE_COMMENT AS `comment`,TABLE_TYPE AS `type`
                FROM information_schema.TABLES
                WHERE TABLE_SCHEMA =DATABASE() ';
        $params = [];
        if (!empty($builder->keyword)) {
            $sql .= 'AND TABLE_NAME LIKE :keyword ';
            $params[':keyword'] = '%' . $builder->getKeywordEscape() . '%';
        }
        $sql .= 'LIMIT ' . $builder->skip . ',' . $builder->page_size;
        $items = $db->createCommand($sql, $params)->queryAll();
        $total = intval($db->createCommand('SELECT FOUND_ROWS() AS total;')->queryScalar());
        return ['items' => $items, 'total' => $total];
    }

    /**
     * 获取对象结构
     * @param ObjectStructQueryBuilder $builder
     * @return array
     */
    public function getObjectStructs(ObjectStructQueryBuilder $builder)
    {
        $db = $this->getDataSource($builder);
        $sql = 'SELECT COLUMN_NAME AS `name`,COLUMN_TYPE AS `type` ,COLUMN_COMMENT AS `comment` 
                FROM information_schema.COLUMNS 
                WHERE TABLE_SCHEMA =DATABASE() AND TABLE_NAME=:table_name
                ORDER BY ORDINAL_POSITION';
        $params = [':table_name' => $builder->obj_name];
        return $db->createCommand($sql, $params)->queryAll();
    }

    /**
     * 获取数据
     * @param DataQueryBuilder $builder
     * @return array
     * @throws \dmp\exception\ArgumentException
     */
    public function getData(DataQueryBuilder $builder)
    {
        list($sql, $params) = (new MySQLDataQueryParser($builder))->parser();
        $db = $this->getDataSource($builder);
        return $db->createCommand($sql, $params)->queryAll();
    }


    /**
     * 获取数据源
     * @param QueryBuilderBase $builder
     * @return Connection
     */
    public function getDataSource(QueryBuilderBase $builder)
    {
        return new Connection();
    }
}
