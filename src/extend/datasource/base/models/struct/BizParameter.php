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
     * 参数类型:sys、query、fixed，必须参数
     * sys:DMP平台内置参数
     * query:URL参数
     * fixed:固定参数，可以自定义，或从values中选择
     * @var string
     */
    public $type = 'fixed';

    /**
     * 参数名称关键字，申明时可为空
     * type='sys':可参考DMP平台中的内置参数列表
     * type='query':URL参数名称，具体可以参考查看报告时URL参数列表
     * type='fixed':此关键字则不会解析
     * @var string
     */
    public $key = '';

    /**
     * 参数范围:all,datasource,dataset
     * all:所有范围，在DMP平台中的数据源与数据集中均可以定义
     * datasource:只在数据源管理时可被定义
     * dataset:只在数据集管理时可被定义
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
