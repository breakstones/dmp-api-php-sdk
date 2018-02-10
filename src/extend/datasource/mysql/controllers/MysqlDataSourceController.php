<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 19:52
 */

namespace dmp\extend\datasource\mysql\controllers;


use dmp\di\Container;
use dmp\extend\datasource\base\interfaces\DataSourceControllerInterface;
use dmp\extend\datasource\base\models\data\DataQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectQueryBuilder;
use dmp\extend\datasource\base\models\struct\ObjectStructQueryBuilder;
use dmp\extend\datasource\mysql\services\MySQLDataSourceService;
use dmp\web\controllers\ControllerBase;

class MysqlDataSourceController extends ControllerBase implements DataSourceControllerInterface
{
    /**
     * mysql数据源业务
     * @var MySQLDataSourceService
     */
    protected $_service;

    /**
     * MysqlDataSourceController constructor.
     * @param $id
     * @param $module
     * @param array $config
     * @throws \ReflectionException
     * @throws \dmp\exception\ArgumentException
     */
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_service = Container::getInstance()->get('dmp\extend\datasource\base\interfaces\DataSourceInterface');
    }

    /**
     * 获取业务参数
     * @return mixed
     */
    public function actionGetBizParams()
    {
        try {
            return $this->jsonData(true, 'success', $this->_service->getBizParams());
        } catch (\Exception $ex) {
            return $this->jsonData(false, $ex->getMessage());
        }
    }

    /**
     * 获取对象
     * @return mixed
     */
    public function actionGetObjects()
    {
        try {
            $builder = new ObjectQueryBuilder($this->getRequestParams());
            return $this->jsonData(true, 'success', $this->_service->getObjects($builder));
        } catch (\Exception $ex) {
            return $this->jsonData(false, $ex->getMessage());
        }
    }

    /**
     * 获取对象结构
     * @return mixed
     */
    public function actionGetObjectStructs()
    {
        try {
            $builder = new ObjectStructQueryBuilder($this->getRequestParams());
            return $this->jsonData(true, 'success', $this->_service->getObjectStructs($builder));
        } catch (\Exception $ex) {
            return $this->jsonData(false, $ex->getMessage());
        }
    }

    /**
     * 获取数据
     * @return mixed
     */
    public function actionGetData()
    {
        try {
            $builder = new DataQueryBuilder($this->getRequestParams());
            return $this->jsonData(true, 'success', $this->_service->getData($builder));
        } catch (\Exception $ex) {
            return $this->jsonData(false, $ex->getMessage());
        }
    }
}
