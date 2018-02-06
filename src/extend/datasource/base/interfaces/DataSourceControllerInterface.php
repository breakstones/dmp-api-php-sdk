<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 19:43
 */

namespace dmp\extend\datasource\base\interfaces;

/**
 * 数据源控制器接口
 * Interface DataSourceControllerInterface
 * @package dmp\extend\datasource\interfaces
 */
interface DataSourceControllerInterface
{
    /**
     * 获取业务参数
     * @return mixed
     */
    public function actionGetBizParamValue();

    /**
     * 获取对象
     * @return mixed
     */
    public function actionGetObjects();

    /**
     * 获取对象结构
     * @return mixed
     */
    public function actionGetObjectStructs();

    /**
     * 获取数据
     * @return mixed
     */
    public function actionGetData();

}
