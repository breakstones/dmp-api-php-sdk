<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 15:03
 */

namespace dmp\exception;

use Exception;
use Throwable;

class ArgumentException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = '参数异常：' . $message;
        parent::__construct($message, $code, $previous);
    }
}
