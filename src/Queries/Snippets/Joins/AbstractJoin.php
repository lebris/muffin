<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Joins;

use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Queries\Snippets\Join;
use Mdd\QueryBuilder\Queries\Snippets;

abstract class AbstractJoin implements Join, Snippet
{
    private
        $table,
        $using,
        $on;

    public function __construct($table, $alias = null)
    {
        $this->table = new Snippets\TableName($table, $alias);
        $this->on = array();
    }

    public function using($column)
    {
        $this->on = array();

        $this->using = new Snippets\Using($column);

        return $this;
    }

    public function on($leftColumn, $rightColumn)
    {
        $this->using = null;
        $this->on[] = new Snippets\On($leftColumn, $rightColumn);

        return $this;
    }

    public function toString()
    {
        $joinQueryPart = sprintf(
            '%s %s',
            $this->getJoinDeclaration(),
            $this->table->toString()
        );

        $joinQueryPart .= $this->buildOnConditionClause();
        $joinQueryPart .= $this->buildUsingConditionClause();

        return $joinQueryPart;
    }

    abstract protected function getJoinDeclaration();

    private function buildUsingConditionClause()
    {
        if(!$this->using instanceof Snippet)
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
            if($on instanceof Snippet)
            {
                $conditionClause[] = $on->toString();
            }
        }

        return empty($conditionClause) ? '' : ' ' . implode('', $conditionClause);
    }
}
