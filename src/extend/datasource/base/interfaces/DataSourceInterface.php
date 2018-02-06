<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 18:03
 */

namespace dmp\extend\datasource\base\interfaces;

use dmp\extend\datasource\base\models\data\DataQueryBuilder;
use dmp\extend\datasource\base\models\QueryBuilderBase;
use dmp\extend\datasource\base\models\struct\BizParameterQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectStructQueryBuilder;


/**
 * 数据源接口
 * Interface DataSourceInterface
 * @package dmp\extend\datasource\interfaces
 */
interface DataSourceInterface
{
    /**
     * 获取业务参数值
     * @param BizParameterQueryBuilder $builder
     * @return mixed
     */
    public function getBizParamValue(BizParameterQueryBuilder $builder);

    /**
     * 获取对象
     * @param ObjectQueryBuilder $builder
     * @return array
     */
    public function getObjects(ObjectQueryBuilder $builder);

    /**
     * 获取对象结构
     * @param ObjectStructQueryBuilder $builder
     * @return array
     */
    public function getObjectStructs(ObjectStructQueryBuilder $builder);

    /**
     * 获取数据
     * @param DataQueryBuilder $builder
     * @return array
     */
    public function getData(DataQueryBuilder $builder);

    /**
     * 获取数据源
     * @param QueryBuilderBase $builder
     * @return mixed
     */
    public function getDataSource(QueryBuilderBase $builder);
}
