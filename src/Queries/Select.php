<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Queries\Snippets\Builders;

class Select implements Query
{
    use
        EscaperAware,
        Builders\Join,
        Builders\Where,
        Builders\GroupBy,
        Builders\OrderBy,
        Builders\Limit;

    private
        $select,
        $from;

    public function __construct($columns = null)
    {
        $this->select = new Snippets\Select();
        $this->where = new Snippets\Where();
        $this->groupBy = new Snippets\GroupBy();
        $this->orderBy = new Snippets\OrderBy();

        $this->select->select($columns);
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildSelect(),
            $this->buildFrom(),
            $this->buildJoin(),
            $this->buildWhere(),
            $this->buildGroupBy(),
            $this->buildOrderBy(),
            $this->buildLimit(),
        );

        return implode(' ', array_filter($queryParts));
    }

    public function from($table, $alias = null)
    {
        $this->from = new Snippets\From($table, $alias);

        return $this;
    }

    public function select($columns)
    {
        $this->select->select($columns);

        return $this;
    }

    private function buildSelect()
    {
        return $this->select->toString();
    }

    private function buildFrom()
    {
        if(!$this->from instanceof Snippet)
        {
            throw new \LogicException('No column for FROM clause');
        }

        return $this->from->toString();
    }
}
