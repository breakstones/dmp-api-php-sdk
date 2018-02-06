<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 19:56
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\Object;

class QueryStructure extends Object
{
    /**
     * 列
     * @var array
     * list of Column
     */
    public $select;

    /**
     * 表
     * @var array
     * list of Table
     */
    public $from;

    /**
     * 条件
     * @var array
     * list of Condition
     */
    public $where;

    /**
     * 分组
     * @var array
     * list of Column
     */
    public $group_by;

    /**
     * 筛选
     * @var array
     * list of Condition
     */
    public $having;

    /**
     * 排序
     * @var array
     * list of Order
     */
    public $order_by;

    /**
     * 返回数据量
     * @var Limit
     */
    public $limit;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('select', __NAMESPACE__ . '\Column', true);
        $this->transformArrayToObject('from', __NAMESPACE__ . '\Table', true);
        $this->transformArrayToObject('where', __NAMESPACE__ . '\Condition', true);
        $this->transformArrayToObject('group_by', __NAMESPACE__ . '\Column', true);
        $this->transformArrayToObject('having', __NAMESPACE__ . '\Condition', true);
        $this->transformArrayToObject('order_by', __NAMESPACE__ . '\Order', true);
        $this->transformArrayToObject('limit', __NAMESPACE__ . '\Limit');
    }
}
