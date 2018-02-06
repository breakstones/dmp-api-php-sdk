<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/31
 * Time: 14:53
 */

namespace dmp\exception;

use Exception;
use Throwable;

class AuthException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = '身份验证异常：' . $message;
        parent::__construct($message, $code, $previous);
    }
}
