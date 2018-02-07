<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:02
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\BaseObject;

class Property extends BaseObject
{
    /**
     * 对象名称
     * @var string
     */
    public $obj_name;

    /**
     * 属性名称
     * @var string
     */
    public $prop_name;

    /**
     * 别名
     * @var string
     */
    public $alias;

    /**
     * 函数表达式
     * @var string
     */
    public $func;

    /**
     * 修饰符, 如 DISTINCT
     * @var string
     */
    public $specifier;

    /**
     * 操作符
     * 支持：+|-|*|/|,
     * @var string
     */
    public $operator;

    /**
     * 组合属性，配合父级type=calc类型使用
     * @var array
     */
    public $props;

    /**
     * 具体的值
     * @var string|integer
     */
    public $value;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('props', __NAMESPACE__ . '\Property', true);
    }
}
