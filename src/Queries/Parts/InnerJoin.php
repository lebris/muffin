<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class InnerJoin implements PartBuilder
{
    private
        $table,
        $alias,
        $using,
        $on;

    public function __construct($table, $alias = null)
    {
        $this->table = (string) $table;
        $this->on = array();

        if(!empty($alias))
        {
            $this->alias = (string) $alias;
        }
    }

    public function using($column)
    {
        $this->on = array();

        $this->using = new Using($column);

        return $this;
    }

    public function on($leftColumn, $rightColumn)
    {
        $this->using = null;
        $this->on[] = new On($leftColumn, $rightColumn);

        return $this;
    }

    public function toString()
    {
        $joinQueryPart = sprintf(
            'INNER JOIN %s',
            $this->buildTableClause()
        );

        $joinQueryPart .= $this->buildOnConditionClause();
        $joinQueryPart .= $this->buildUsingConditionClause();

        return $joinQueryPart;
    }

    private function buildTableClause()
    {
        $tableClause = $this->table;

        if(! empty($this->alias))
        {
            $tableClause .= ' AS ' . $this->alias;
        }

        return $tableClause;
    }

    private function buildUsingConditionClause()
    {
        if(!$this->using instanceof PartBuilder)
        {
            return '';
        }

        return ' ' . $this->using->toString();
    }

    private function buildOnConditionClause()
    {
        $conditionClause = array();

        foreach($this->on as $on)
        {
            if($on instanceof PartBuilder)
            {
                $conditionClause[] = $on->toString();
            }
        }

        return empty($conditionClause) ? '' : ' ' . implode('', $conditionClause);
    }
}