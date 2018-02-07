<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:45
 */

namespace dmp\extend\datasource\base\models\data;

use dmp\base\BaseObject;

/**
 * 查询对象
 * Class Object
 * @package dmp\extend\datasource\base\models\data
 */
class Object extends BaseObject
{
    /**
     * 名称
     * @var string
     */
    public $name;

    /**
     * 关联类型
     * @var string
     */
    public $join_type;

    /**
     * 关联条件
     * @var array
     */
    public $ref_clause;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('ref_clause', __NAMESPACE__ . '\Condition', true);
    }
}
