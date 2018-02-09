<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 17:32
 */

namespace dmp\extend\datasource\base\models;


use dmp\base\BaseObject;

class QueryBuilderBase extends BaseObject
{
    /**
     * 自定义参数
     * @var array
     */
    public $biz_params;

    /**
     * 获取自定义参数值
     * @param $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public function getBizParamValue($key, $defaultValue = null)
    {
        if (empty($this->biz_params) || !isset($this->biz_params[$key])) {
            return $defaultValue;
        }
        return $this->biz_params[$key];
    }
}
