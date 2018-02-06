<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 17:39
 */

namespace dmp\extend\datasource\base\models\struct;


use dmp\extend\datasource\base\models\QueryBuilderBase;


/**
 * 对象结构查询
 * Class ObjectStructQuery
 * @package dmp\extend\datasource\models\struct
 */
class ObjectStructQueryBuilder extends QueryBuilderBase
{
    /**
     * 表名
     * @var string
     */
    public $object_name;
}
