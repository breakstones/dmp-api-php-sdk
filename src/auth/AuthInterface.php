<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/30
 * Time: 16:01
 */

namespace dmp\auth;

interface AuthInterface
{
    /**
     * 校验
     * @param object $data
     * @return bool
     */
    public function verify($data);
}
