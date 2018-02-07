<?php
/**
 * Created by wangl10@mingyuanyun.com.
 * Date: 2018/2/7
 * Time: 14:09
 */

namespace dmp\extend\datasource\mysql\services;


use dmp\exception\ArgumentException;
use dmp\extend\datasource\base\models\data\Condition;
use dmp\extend\datasource\base\models\data\DataQueryBuilder;
use dmp\extend\datasource\base\models\data\Limit;
use dmp\extend\datasource\base\models\data\Object as Obj;
use dmp\extend\datasource\base\models\data\Order;
use dmp\extend\datasource\base\models\data\Property;


class MySQLDataQueryParser
{
    /**
     * @var DataQueryBuilder
     */
    public $queryBuilder;

    /**
     * 参数列表
     * @var array
     */
    private $_params = [];

    /**
     * 用于参数名称递增
     * @var int
     */
    private $_paramIndex = 0;

    public function __construct(DataQueryBuilder $builder)
    {
        $this->queryBuilder = $builder;
    }

    /**
     * 解析参数
     * @throws ArgumentException
     */
    public function parser()
    {
        $this->_params = [];
        $this->_paramIndex = 0;

        $select = $this->parserSelect();
        if (empty($select)) {
            throw new ArgumentException('缺少select');
        }
        $table = $this->parserTable();
        if (empty($table)) {
            throw new ArgumentException('缺少table');
        }

        $sql = "SELECT {$select} FROM {$table} ";
        $where = $this->parserWhere();
        if (!empty($where)) {
            $sql .= "WHERE {$where} ";
        }
        $group_by = $this->parserGroupBy();
        if (!empty($group_by)) {
            $sql .= "GROUP BY {$group_by} ";
        }
        $having = $this->parserHaving();
        if (!empty($having)) {
            $sql .= "HAVING {$having} ";
        }
        $order_by = $this->parserOrderBy();
        if (!empty($order_by)) {
            $sql .= "ORDER BY {$order_by} ";
        }
        $limit = $this->parserLimit();
        if (!empty($limit)) {
            $sql .= $limit;
        }
        return array($sql, $this->_params);
    }

    private function getParamName()
    {
        $this->_paramIndex++;
        return ":p{$this->_paramIndex}";
    }

    /**
     * 解析查询列
     * @return array
     * @throws ArgumentException
     */
    private function parserSelect()
    {
        $selects = $this->queryBuilder->query_structure->select;
        if (empty($selects)) {
            throw new ArgumentException('select部分不能为空');
        }
        $res = [];
        foreach ($selects as $select) {
            if (!($select instanceof Property)) {
                continue;
            }
            $res[] = $this->parserColumnContent($select);
        }
        return join(',', $res);
    }

    /**
     * 解析查询列
     * @param Property $property
     * @return string
     */
    private function parserColumnContent(Property $property)
    {
        $str = '';
        if (!empty($property->specifier)) {
            $str .= " {$property->specifier} ";
        }
        //解析操作符
        if (!empty($property->operator)) {
            $str .= " {$property->operator} ";
        }
        //解析函数
        if (!empty($property->func)) {
            $str .= " $property->func";
        }
        //子列
        if (!empty($property->props) && is_array($property->props)) {
            $str .= '(';
            foreach ($property->props as $prop) {
                $str .= $this->parserColumnContent($prop);
            }
            $str .= ')';
        }
        //列与值
        if (!empty($property->prop_name)) {
            if (!empty($property->obj_name)) {
                $str .= "`{$property->obj_name}`.";
            }
            $str .= "`{$property->prop_name}`";
        } else if (!empty($property->value)) {
            $paramName = $this->getParamName();
            $this->_params[$paramName] = $property->value;
            $str .= $paramName;
        }
        //解析别名
        if (!empty($property->alias)) {
            $str .= " AS `{$property->alias}`";
        }
        return $str;
    }

    /**
     * @return array
     * @throws ArgumentException
     */
    private function parserTable()
    {
        $objects = $this->queryBuilder->query_structure->object;
        if (empty($objects)) {
            throw new ArgumentException('object部分丢失');
        }
        $res = [];
        foreach ($objects as $object) {
            if (!($object instanceof Obj)) {
                continue;
            }
            $res[] = $this->parserTableContent($object);
        }
        return join(' ', $res);
    }

    /**
     * @param Obj $obj
     * @return string
     * @throws ArgumentException
     */
    private function parserTableContent(Obj $obj)
    {
        if (empty($obj->name)) {
            throw new ArgumentException('表名丢失');
        }
        $str = '';
        if (!empty($obj->join_type)) {
            $str .= " {$obj->join_type} JOIN `{$obj->name}`";
            if (empty($obj->ref_clause)) {
                throw new ArgumentException('表关联部分丢失');
            }
            $str .= ' ON ';
            foreach ($obj->ref_clause as $item) {
                $str .= $this->parserConditionContent($item);
            }
        } else {
            $str .= " `{$obj->name}`";
        }
        return $str;
    }

    /**
     * @param Condition $condition
     * @return string
     * @throws ArgumentException
     */
    private function parserConditionContent(Condition $condition)
    {
        $str = '';
        if (!empty($condition->logical_relation)) {
            $str .= " {$condition->logical_relation}";
        }
        if (!empty($condition->conditions) && is_array($condition->conditions)) {
            $str .= '(';
            foreach ($condition->conditions as $cond) {
                $str .= $this->parserConditionContent($cond);
            }
            $str .= ')';
        } else {
            if (empty($condition->left) || empty($condition->operator) || empty($condition->right)) {
                throw new ArgumentException('条件左边部分丢失');
            }
            $str .= " {$this->parserColumnContent($condition->left)} {$condition->operator} {$this->parserColumnContent($condition->right)}";
        }
        return $str;
    }

    /**
     * @return string
     * @throws ArgumentException
     */
    private function parserWhere()
    {
        $res = '';
        $wheres = $this->queryBuilder->query_structure->where;
        if (!empty($wheres) && is_array($wheres)) {
            foreach ($wheres as $where) {
                $res .= $this->parserConditionContent($where);
            }
        }
        return $res;
    }

    /**
     * @return string
     */
    private function parserGroupBy()
    {
        $res = [];
        $groups = $this->queryBuilder->query_structure->group_by;
        if (!empty($groups) && is_array($groups)) {

            foreach ($groups as $group) {
                $res [] = $this->parserColumnContent($group);
            }
        }
        return join(',', $res);
    }

    /**
     * @return string
     * @throws ArgumentException
     */
    private function parserHaving()
    {
        $res = '';
        $filters = $this->queryBuilder->query_structure->having;
        if (!empty($filters) && is_array($filters)) {
            foreach ($filters as $filter) {
                $res .= $this->parserConditionContent($filter);
            }
        }
        return $res;
    }

    private function parserOrderBy()
    {
        $res = [];
        $order = $this->queryBuilder->query_structure->order_by;
        if (!empty($order) && is_array($order)) {
            foreach ($order as $item) {
                if (!($item instanceof Order)) {
                    continue;
                }
                $method = $item->method ?: '';
                $res[] = " `{$item->obj_name}`.`{$item->prop_name}` {$method}";
            }
        }
        return join(',', $res);
    }

    private function parserLimit()
    {
        $res = '';
        $limit = $this->queryBuilder->query_structure->limit;
        if (!empty($limit) && $limit instanceof Limit) {
            $res .= '  LIMIT :lmt_offset,:lmt_row';
            $this->_params[':lmt_offset'] = $limit->offset;
            $this->_params[':lmt_row'] = $limit->row;
        }
        return $res;
    }
}
