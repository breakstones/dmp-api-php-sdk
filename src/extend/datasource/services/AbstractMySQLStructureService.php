<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 11:36
 */

namespace dmp\extend\datasource\services;


use dmp\extend\datasource\models\TableDynamicStructureModel;
use dmp\extend\datasource\models\TableQueryModel;
use dmp\extend\datasource\models\TableStructureModel;
use dmp\extend\datasource\repositories\MySQLStructureRepository;

abstract class AbstractMySQLStructureService implements StructureServiceInterface
{

    /**
     * @var MySQLStructureRepository
     */
    private $_repository;

    public function __construct(MySQLStructureRepository $repository)
    {
        $this->_repository = $repository;
    }

    /**
     * 获取数据表
     * @param TableQueryModel $model
     * @return array
     * @throws \yii\db\Exception
     */
    public function getTables(TableQueryModel $model)
    {
        return $this->_repository->getTables($model);
    }

    /**
     * 获取数据表结构
     * @param TableStructureModel $model
     * @return array
     * @throws \yii\db\Exception
     */
    public function getTableStructure(TableStructureModel $model)
    {
        return $this->_repository->getTableStructure($model);
    }

    /** 获取动态数据表结构
     * @param TableDynamicStructureModel $model
     * @return array
     */
    public function getTableDynamicStructure(TableDynamicStructureModel $model)
    {
        return [];
    }
}
