<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:02
 */

namespace dmp\extend\datasource\models\query;


use dmp\base\Object;

class Column extends Object
{
    /**
     * 表名
     * @var string
     */
    public $table_name;

    /**
     * 列名
     * @var string
     */
    public $col_name;

    /**
     * 别名
     * @var string
     */
    public $alias;

    /**
     * 类型
     * @var string
     * 支持：col|calc|val
     */
    public $type;

    /**
     * 函数表达式
     * @var string
     */
    public $func;

    /**
     * 函数参数
     * @var array
     */
    public $func_params;


    /**
     * 计算操作符，配合父级type=calc类型使用
     * 支持：+|-|*|/
     * @var string
     */
    public $calc_operator;

    /**
     * 组合列，配合父级type=calc类型使用
     * @var array
     */
    public $cols;

    /**
     * 具体的值
     * @var string|integer
     */
    public $value;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('func_params', __NAMESPACE__ . '\FunctionParameter', true);
        $this->transformArrayToObject('cols', __NAMESPACE__ . '\Column', true);
    }
}
