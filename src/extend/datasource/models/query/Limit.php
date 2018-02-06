<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 21:00
 */

namespace dmp\extend\datasource\models\query;


use dmp\base\Object;

class Limit extends Object
{
    /**
     * 位移行数
     * @var integer
     */
    public $offset;

    /**
     * 获取行数
     * @var integer
     */
    public $row;
}
