<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/31
 * Time: 17:37
 */

namespace dmp\web\controllers;


use yii\web\Controller;
use yii\web\Response;

class ControllerBase extends Controller
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;
        parent::__construct($id, $module, $config);
    }

    /**
     * 返回JSON数据
     * @param bool $result : default true,
     * @param string $msg : default '' 自定义消息
     * @param object|array $data : default null 自定义数据，不设置则不输出该属性
     * @return array JSON Data
     */
    public function jsonData($result = true, $msg = '', $data = null)
    {
        $jsonObject = ['result' => $result, 'msg' => $msg, 'data' => $data];
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $jsonObject;
    }

    public function behaviors()
    {
        return [
            ['class' => 'dmp\web\filters\AuthorizationFilter']
        ];
    }

    public function getRequestParams()
    {
        $request = \Yii::$app->request;
        $params = $request->isPost ? $request->post() : $request->get();
        if (empty($params)) {
            $rawBody = $request->getRawBody();
            if (!empty($rawBody)) {
                $params = json_decode($rawBody, true);
            }
        }
        return $params;
    }
}
