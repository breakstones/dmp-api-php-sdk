<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/31
 * Time: 11:30
 */

namespace dmp\helper;

use dmp\exception\RequestException;

class Request
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    static private $_instance;
    private $_endpoint;

    /**
     * Request constructor.
     * @throws RequestException
     */
    private function __construct()
    {
        $this->_endpoint = getenv('DMP_ENDPOINT');
        if (!$this->_endpoint) {
            throw new RequestException('缺少DMP_ENDPOINT配置');
        }
        $this->_endpoint .= '/api/';

    }

    /**
     * 获取请求实例
     * @return Request
     * @throws RequestException
     */
    static public function getInstance()
    {
        if (!(self::$_instance instanceof Request)) {
            self::$_instance = new Request();
        }
        return self::$_instance;
    }

    /**
     * POST 请求
     * @param string $token
     * @param string $method
     * @param string $api
     * @param array $data :default null
     * @return array
     * @throws RequestException
     */
    public function invoke($token, $method, $api, $data = null)
    {

        $url = $this->_endpoint . $api;
        if ($method == Request::METHOD_GET && isset($data)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($method == Request::METHOD_POST) {
            curl_setopt($curl, CURLOPT_POST, 1);
            if (isset($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_COOKIE, 'token=' . $token);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($status_code !== 200) {
            throw new RequestException($status_code . ' ' . $url . ' ' . $data);
        }
        return json_decode($data);
    }
}
