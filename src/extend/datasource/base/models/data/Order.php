<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 20:58
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\Object;

class Order extends Object
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
     * 排序方法：AES|DESC
     * @var string
     */
    public $method;
}
