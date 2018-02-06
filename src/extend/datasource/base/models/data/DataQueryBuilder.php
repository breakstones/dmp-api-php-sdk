<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 19:54
 */

namespace dmp\extend\datasource\base\models\data;

use dmp\extend\datasource\base\models\QueryBuilderBase;

class DataQueryBuilder extends QueryBuilderBase
{
    /**
     * @var QueryStructure
     */
    public $query_structure;

    public function init()
    {
        parent::init();
        $this->transformArrayToObject('query_structure', __NAMESPACE__ . '\QueryStructure');
    }
}
