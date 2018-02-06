<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 11:55
 */

namespace dmp\extend\datasource\repositories;


use dmp\extend\datasource\models\TableDynamicStructureModel;
use dmp\extend\datasource\models\TableQueryModel;
use dmp\extend\datasource\models\TableStructureModel;
use dmp\extend\datasource\repositories\interfaces\MySQLSourceInterface;

class MySQLStructureRepository
{
    /**
     * @var MySQLSourceInterface
     */
    private $_source;

    /**
     * MySQLStructureRepository constructor.
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function __construct()
    {

        $this->_source = \Yii::$container->get('dmp\extend\datasource\repositories\interfaces\MySQLSourceInterface');
    }

    /**
     * 获取数据表
     * @param TableQueryModel $model
     * @return array
     * @throws \yii\db\Exception
     */
    public function getTables(TableQueryModel $model)
    {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS TABLE_NAME AS `name`,TABLE_COMMENT AS `comment`,TABLE_TYPE
                FROM information_schema.TABLES
                WHERE TABLE_SCHEMA =DATABASE() ';
        $params = [];
        if (!empty($model->keyword)) {
            $sql .= 'AND TABLE_NAME LIKE :keyword ';
            $params[':keyword'] = '%' . $model->getKeywordEscape() . '%';
        }
        $sql .= 'LIMIT ' . $model->skip . ',' . $model->page_size;
        $db = $this->_source->getDB();
        $items = $db->createCommand($sql, $params)->queryAll();
        $total = $db->createCommand('SELECT FOUND_ROWS() AS total;')->queryScalar();
        return ['items' => $items, 'total' => $total];
    }

    /**
     * 获取数据表结构
     * @param TableStructureModel $model
     * @return array
     * @throws \yii\db\Exception
     */
    public function getTableStructure(TableStructureModel $model)
    {
        $sql = 'SELECT COLUMN_NAME AS `name`,COLUMN_TYPE AS `type` ,COLUMN_COMMENT AS `comment` 
                FROM information_schema.COLUMNS 
                WHERE TABLE_SCHEMA =DATABASE() AND TABLE_NAME=:table_name
                ORDER BY ORDINAL_POSITION';
        $params = [':table_name' => $model->table_name];
        $items = $this->_source->getDB()->createCommand($sql, $params)->queryAll();
        return ['items' => $items, 'total' => count($items)];
    }

    public function getTableDynamicStructure(TableDynamicStructureModel $model)
    {
        $this->_source->getDB()->createCommand()->queryOne();
    }
}
