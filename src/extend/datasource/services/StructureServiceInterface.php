<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 11:35
 */

namespace dmp\extend\datasource\services;


use dmp\extend\datasource\models\TableDynamicStructureModel;
use dmp\extend\datasource\models\TableQueryModel;
use dmp\extend\datasource\models\TableStructureModel;

interface StructureServiceInterface
{
    /**
     * 获取数据表
     * @param TableQueryModel $model
     * @return array
     */
    public function getTables(TableQueryModel $model);

    /**
     * 获取数据表结构
     * @param TableStructureModel $model
     * @return array
     */
    public function getTableStructure(TableStructureModel $model);

    /** 获取动态数据表结构
     * @param TableDynamicStructureModel $model
     * @return array
     */
    public function getTableDynamicStructure(TableDynamicStructureModel $model);
}
