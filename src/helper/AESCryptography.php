<?php

/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/30
 * Time: 15:52
 */

namespace dmp\helper;

class AESCryptography
{
    /**
     * 加密
     * @param string $data
     * @param string $key
     * @return string
     */
    public static function encrypt($data, $key)
    {
        return bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $key));
    }

    /**
     * 解密
     * @param string $data
     * @param string $key
     * @return string
     */
    public static function decrypt($data, $key)
    {
        $res = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, hex2bin($data), MCRYPT_MODE_CBC, $key), chr(0));
        if (!mb_check_encoding($res)) {
            return false;
        }
        return $res;
    }
}
