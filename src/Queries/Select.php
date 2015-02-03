<?php

namespace Muffin\Queries;

use Muffin\Query;
use Muffin\Condition;
use Muffin\Traits\EscaperAware;
use Muffin\Snippet;
use Muffin\Queries\Snippets\Builders;
use Muffin\Queries\Snippets\Having;

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
        $from,
        $having;

    public function __construct($columns = array())
    {
        $this->select = new Snippets\Select();
        $this->where = new Snippets\Where();
        $this->groupBy = new Snippets\GroupBy();
        $this->having = new Snippets\Having();
        $this->orderBy = new Snippets\OrderBy();

        $this->select->select($columns);
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildSelect(),
            $this->buildFrom(),
            $this->buildJoin(),
            $this->buildWhere($this->escaper),
            $this->buildGroupBy(),
            $this->buildHaving(),
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

    public function having(Condition $condition)
    {
        $this->having->having($condition);

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

    private function buildHaving()
    {
        $this->having->setEscaper($this->escaper);

        return $this->having->toString();
    }
}
