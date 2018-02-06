<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 10:07
 */

namespace dmp\web\models;


use yii\base\Model;

class ModelBase extends Model
{
    public function __construct($autoSetAttributes = true, $config = [])
    {
        parent::__construct($config);
    }

    public function setAttributesByRequest()
    {
        $request = \Yii::$app->request;
        $this->setAttributes($request->isPost ? $request->post() : $request->get(), false);
    }
}
