<?php

/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/30
 * Time: 15:52
 */

namespace dmp\auth;

use dmp\exception\AuthException;
use dmp\helper\AESCryptography;
use Exception;

/***
 * Class JWTAuth
 * @package dmp\auth
 */
class JWTAuth implements AuthInterface
{
    /**
     * token加密密钥
     * @var string
     */
    private $_secret;

    /**
     * JWTAuth constructor.
     * @param null|string $secret
     * @throws AuthException
     */
    public function __construct($secret = null)
    {
        $this->_secret = $secret ?: getenv('DMP_SECRET');
        if (!$this->_secret) {
            throw new AuthException('缺少DMP_SECRET配置');
        }
    }

    /**
     * 校验
     * @param object $data
     * @return bool
     * @throws AuthException
     */
    public function verify($data)
    {
        try {
            return AESCryptography::decrypt($data, $this->_secret);
        } catch (Exception $e) {
            throw new AuthException('token校验失败');
        }
    }
}
