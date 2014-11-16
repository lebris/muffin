<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\PartBuilders;
use Mdd\QueryBuilder\Condition;

class Select implements Query
{
    private
        $conditions,
        $columns,
        $from;

    public function __construct($columns = null)
    {
        $this->columns = array();
        $this->conditions = array();

        $this->addColumns($columns);
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
        $this->addColumns($columns);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->addCondition($condition);

        return $this;
    }

    private function buildSelect()
    {
        return sprintf(
            'SELECT %s',
            implode(', ', $this->columns)
        );
    }

    private function buildFrom()
    {
        return $this->from->toString();
    }

    private function buildWhere()
    {
        return $this->from->toString();
    }

    private function addColumns($columns)
    {
        $columns = array_filter($this->ensureIsArray($columns));

        foreach($columns as $column)
        {
            if(! is_string($column))
            {
                throw new \InvalidArgumentException('Column name must be a string.');
            }
        }

        $this->columns = array_unique(array_merge($this->columns, $columns));
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