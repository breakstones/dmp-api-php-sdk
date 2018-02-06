<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/2
 * Time: 15:00
 */

namespace dmp\base;


class Object
{
    public function __construct($properties = [])
    {
        if (!empty($properties)) {
            $this->setProperties($properties);
        }
        $this->init();
    }

    private function setProperties($properties = [])
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    public function init()
    {

    }

    protected function transformArrayToObject($propertyName, $classType, $isObjectArray = false)
    {
        if (!isset($this->$propertyName) || empty($this->$propertyName) || !is_array($this->$propertyName)) {
            return;
        }
        if ($isObjectArray) {
            $tmpArray = [];
            foreach ($this->$propertyName as $properties) {
                if (!isset($properties) || empty($properties) || !is_array($properties)) {
                    continue;
                }
                $tmpArray[] = new $classType($properties);
            }
            $this->$propertyName = $tmpArray;
        } else {
            $this->$propertyName = new $classType($this->$propertyName);
        }
    }
}
