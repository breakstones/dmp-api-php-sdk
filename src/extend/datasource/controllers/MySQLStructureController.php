<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 9:59
 */

namespace dmp\extend\datasource\controllers;


use dmp\extend\datasource\services\AbstractMySQLStructureService;
use dmp\web\controllers\ControllerBase;

class MySQLStructureController extends ControllerBase
{
    /**
     * @var AbstractMySQLStructureService
     */
    private $_service;

    public function __construct($id, $module, AbstractMySQLStructureService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_service = $service;
    }

    public function actionTables()
    {

    }
}
