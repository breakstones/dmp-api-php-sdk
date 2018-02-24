# DMP API 数据源(mysql)接入向导
目前仅支持mysql数据源接入，待后续实现不同数据源的接入(oracle、mssql...)

#### 1.安装SDK

```Bash
composer require mysoft/dmp
```
#### 2.关键配置
配置DMP_SECRET & 注入自定义数据源服务

config.php  
```php
<?php
putenv('DMP_SECRET=1234567890123456');
\dmp\di\Container::getInstance()->set('dmp\extend\datasource\base\interfaces\DataSourceInterface', 'DataSourceService');

```

#### 2.继承数据源标准Controller
SDK中的Controller目前是基于Yii 2.0 实现。
若与现有使用框架不匹配，则自己实现dmp\extend\datasource\base\interfaces\DataSourceControllerInterface即可。

DataSourceController.php
```php

use dmp\extend\datasource\mysql\controllers\MysqlDataSourceController;

class DataSourceController extends MysqlDataSourceController
{
    
}

```

#### 3.实现数据源服务关键代码
DataSourceService.php

```php
<?php

use dmp\extend\datasource\base\models\data\Condition;
use dmp\extend\datasource\base\models\data\DataQueryBuilder;
use dmp\extend\datasource\base\models\data\Property;
use dmp\extend\datasource\base\models\QueryBuilderBase;
use dmp\extend\datasource\base\models\struct\BizParameter;
use dmp\extend\datasource\mysql\services\MySQLDataSourceService;
use dmp\helper\db\mysql\Connection;

class DataSourceService extends MySQLDataSourceService
{
    /**
     * 向平台申明所需参数，在DMP数据源与数据集中可配置该参数的具体值。
     * 在接口调用时，会携带具体值。获取方式：$builder->getBizParamValue('parameter_name')
     * @return array
     */
    public function getBizParams()
    {
        $proCode = new BizParameter();
        $proCode->range = 'datasource';     //指定参数在定义数据源时进行配置
        $proCode->type = 'sys';             //DMP内置参数值
        $proCode->key = 'project_code'; //DMP平台内置租户代码
        $proCode->name = 'proj_code';       //参数名称
        $proCode->description = '租户代码'; //参数描述
        $proCode->required = true;          //设置为必须参数
        $proCode->values = [];              //可选值

        $userID = new BizParameter();
        $userID->range = 'dataset';
        $userID->type = 'query';
        $userID->key = 'user_id'; //DMP报告请求参数
        $userID->name = 'user_id';
        $userID->description = '登录用户ID';
        $userID->required = true;
        $userID->values = [];

        return [$proCode, $userID];
    }

    /***
     * 获取数据
     * ps:无任何的自定义业务需求，则不必重写该函数
     * @param DataQueryBuilder $builder
     * @return array
     * @throws \dmp\exception\ArgumentException
     */
    public function getData(DataQueryBuilder $builder)
    {
        //获取user_id
        $userID = $builder->getBizParamValue('user_id');
        $tableNames = $builder->query_structure->getObjectNames();
        foreach ($tableNames as $tableName) {
            //增加用户过滤
            $builder->query_structure->where[] = new Condition([
                'logical_relation' => empty($builder->query_structure->where) ? '' : 'AND',
                'left' => new Property([
                    'obj_name' => $tableName,
                    'prop_name' => 'user_id',
                ]),
                'operator' => '=',
                'right' => new Property([
                    'value' => $userID
                ]),
            ]);
        }
        return parent::getData($builder);
    }

    /**
     * 获取MySQL连接信息
     * @param QueryBuilderBase $builder
     * @return Connection
     */
    public function getDataSource(QueryBuilderBase $builder)
    {
        /*
         多租户需求：可以根据业务中定义的租户代码，返回不同的连接
         */
        $connParams = [
            'host' => '127.0.0.1',
            'db' => 'database',
            'user' => 'uid',
            'password' => 'pwd'
        ];
        return new Connection($connParams);
    }
}

```
