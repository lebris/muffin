<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\PartBuilders;
use Mdd\QueryBuilder\Condition;

class Select implements Query
{
    private
        $conditions,
        $select,
        $from;

    public function __construct($columns = null)
    {
        $this->select = new PartBuilders\Select();
        $this->conditions = array();

        $this->select->select($columns);
    }

    public function toString()
    {
        return sprintf(
            '%s %s',
            $this->buildSelect(),
            $this->buildFrom()
        );
    }

    public function from($table)
    {
        $this->from = new PartBuilders\From($table);

        return $this;
    }

    public function select($columns)
    {
        $this->select->select($columns);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->addCondition($condition);

        return $this;
    }

    private function buildSelect()
    {
        return $this->select->toString();
    }

    private function buildFrom()
    {
        return $this->from->toString();
    }

    private function buildWhere()
    {
        return $this->from->toString();
    }

    private function addCondition(Condition $condition)
    {
        $this->conditions[] = $condition;
    }

    private function ensureIsArray($select)
    {
        if(! is_array($select))
        {
            $select = array($select);
        }

        return $select;
    }
}