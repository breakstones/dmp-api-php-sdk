<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/31
 * Time: 12:46
 */

namespace dmp\exception;

use Exception;
use Throwable;

class RequestException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = '请求异常：' . $message;
        parent::__construct($message, $code, $previous);
    }
}
