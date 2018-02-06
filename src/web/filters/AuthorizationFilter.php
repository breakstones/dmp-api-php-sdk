<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/1/31
 * Time: 14:45
 */

namespace dmp\web\filters;

use dmp\auth\JWTAuth;
use dmp\exception\AuthException;
use Yii;
use yii\base\ActionFilter;

class AuthorizationFilter extends ActionFilter
{
    private $_jwt;

    /**
     * AuthorizationFilter constructor.
     * @param array $config
     * @throws AuthException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_jwt = new JWTAuth();
    }

    /***
     * @param \yii\base\Action $action
     * @return bool
     * @throws AuthException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $token = Yii::$app->request->cookies->getValue('token');
            if (!$token) {
                throw new AuthException('token无效');
            }
            $res = $this->_jwt->verify($token);
            if (!$res) {
                \Yii::$app->response->setStatusCode(401, 'UnAuthorized');
            }
            return $res;
        } else {
            return false;
        }
    }
}
