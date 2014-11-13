<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\PartBuilders;

class Select implements Query
{
    private
        $columns,
        $from;

    public function __construct($columns = null)
    {
        $this->columns = array();

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

    private function addColumns($columns)
    {
        $columns = $this->ensureIsArray($columns);

        foreach($columns as $column)
        {
            if(! is_string($column))
            {
                throw new \InvalidArgumentException('Column name must be a string.');
            }
        }

        $this->columns = array_filter(array_unique(array_merge($this->columns, $columns)));
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