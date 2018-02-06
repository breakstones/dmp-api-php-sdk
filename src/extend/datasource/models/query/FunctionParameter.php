<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:35
 */

namespace dmp\extend\datasource\models\query;


use dmp\base\Object;

class FunctionParameter extends Object
{
    /**
     * 参数类型
     * @var string
     * 支持：val|col
     */
    public $type = 'val';

    /**
     * 参数名称
     * @var string
     */
    public $name;

    /**
     * 参数类型为“col”时 ，value为Column类型
     * @var string|integer|Column
     */
    public $value;

    public function init()
    {
        parent::init();
        if ($this->type === 'val') {
            $this->transformArrayToObject('value', __NAMESPACE__ . '\Column');
        }
    }
}
