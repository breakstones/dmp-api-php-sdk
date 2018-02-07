<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:50
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\BaseObject;

class Condition extends BaseObject
{
    /**
     * 逻辑关系 ：AND|OR，没有关联默认为空
     * @var string
     */
    public $logical_relation;

    /**
     * 左边表达式
     * @var string|integer|Property
     */
    public $left;

    /**
     * 运算符:<|>|=|<>|LIKE
     * @var string
     */
    public $operator;

    /**
     * 右边表达式
     * @var string|integer|Property
     */
    public $right;

    /**
     * conditions与left、operator、right互斥，此处实现嵌套逻辑
     * @var array
     */
    public $conditions = [];

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('left', __NAMESPACE__ . '\Property');
        $this->transformArrayToObject('right', __NAMESPACE__ . '\Property');
        $this->transformArrayToObject('conditions', __NAMESPACE__ . '\Condition', true);
    }
}
