<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 19:54
 */

namespace dmp\extend\datasource\models\query;


use dmp\base\Object;

class QueryBuilder extends Object
{
    public $biz_params;

    public $query_structure;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('query_structure', __NAMESPACE__ . '\QueryStructure');
    }
}
