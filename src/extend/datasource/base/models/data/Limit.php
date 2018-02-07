<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/5
 * Time: 21:00
 */

namespace dmp\extend\datasource\base\models\data;


use dmp\base\BaseObject;

class Limit extends BaseObject
{
    /**
     * 位移行数
     * @var integer
     */
    public $offset = 0;

    /**
     * 获取行数
     * @var integer
     */
    public $row = 10;
}
