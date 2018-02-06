<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:45
 */

namespace dmp\extend\datasource\models\query;


use dmp\base\Object;

class Table extends Object
{
    /**
     * 表名
     * @var string
     */
    public $table_name;

    /**
     * 连接类型
     * @var string
     */
    public $join_type;

    /**
     * 连接条件
     * @var array
     */
    public $ref_clause;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('ref_clause', __NAMESPACE__ . '\Condition', true);
    }
}
