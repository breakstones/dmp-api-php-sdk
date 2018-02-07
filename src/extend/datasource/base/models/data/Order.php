<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:58
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\BaseObject;

class Order extends BaseObject
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
     * 排序方法：AES|DESC
     * @var string
     */
    public $method;
}
