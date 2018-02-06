<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 13:05
 */

namespace dmp\extend\datasource\repositories\interfaces;


interface MySQLSourceInterface
{
    /**
     * @param array $params
     * @return \yii\db\Connection
     */
    public function getDB(array $params = []);
}
