<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/10
 * Time: 11:01
 */

namespace dmp\extend\datasource\base\models\struct;

use dmp\base\BaseObject;

/**
 * 数据源及数据集自定义参数
 * Class BizParameter
 * @package dmp\extend\datasource\base\models\struct
 */
class BizParameter extends BaseObject
{
    /**
     * 参数类型:dynamic、fixed
     * dynamic：动态参数，从DMP平台中自由选择内置变量，或者请求参数
     * fixed:固定参数，可以自定义，或从default_value中选取
     * @var string
     */
    public $type = 'dynamic';

    /**
     * 参数范围:all,datasource,dataset
     * all:所有范围，在DMP平台中的数据源与数据集中均可以定义
     * datasource:
     * @var string
     */
    public $range = 'all';

    /**
     * 参数名称
     * @var string
     */
    public $name;

    /**
     * 描述
     * @var string
     */
    public $description;

    /**
     * 参考参数值
     * @var array
     */
    public $values;

    /**
     * 参数是否必须
     * @var bool
     */
    public $required;
}
