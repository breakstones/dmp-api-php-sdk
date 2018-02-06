<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 19:18
 */

namespace dmp\di;


class Instance
{
    /**
     * @var string
     */
    public $id;

    /**
     * 构造函数
     * @param string $id 类唯一ID
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * 获取实例
     * @param $id
     * @return Instance
     */
    public static function getInstance($id)
    {
        return new self($id);
    }
}
