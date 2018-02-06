<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/6
 * Time: 17:34
 */

namespace dmp\extend\datasource\base\models\struct;


use dmp\extend\datasource\base\models\QueryBuilderBase;

/**
 * 对象查询
 * Class ObjectQuery
 * @package dmp\extend\datasource\models\struct
 */
class ObjectQueryBuilder extends QueryBuilderBase
{
    /**
     * 当前页
     * @var int
     */
    public $page = 1;

    /**
     * 分页大小
     * @var int
     */
    public $page_size = 10;

    /**
     * 关键字
     * @var string
     */
    public $keyword = '';

    /**
     * skip
     * @var int
     */
    public $skip = 1;

    public function init()
    {
        parent::init();
        $this->page = intval($this->page);
        if ($this->page < 1) {
            $this->page = 1;
        }
        $this->page_size = intval($this->page_size);
        if ($this->page_size < 1) {
            $this->page_size = 10;
        }
        $this->skip = ($this->page - 1) * $this->page_size;
    }

    public function getKeywordEscape()
    {
        return str_replace('_', '\\_', $this->keyword) ? !empty($this->keyword) : $this->keyword;
    }
}
