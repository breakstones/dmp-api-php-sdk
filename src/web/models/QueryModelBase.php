<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/1
 * Time: 10:18
 */

namespace dmp\web\models;


class QueryModelBase extends ModelBase
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

    public function __construct($autoSetAttributes = true, $config = [])
    {
        parent::__construct($autoSetAttributes, $config);
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
