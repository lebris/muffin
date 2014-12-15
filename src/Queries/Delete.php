<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Queries\Snippets\Builders;

class Delete implements Query
{
    use
        EscaperAware,
        Builders\Join;

    private
        $from,
        $where;

    public function __construct($table = null, $alias = null)
    {
        if(!empty($table))
        {
            $this->from($table, $alias);
        }

        $this->where = new Snippets\Where();
    }

    public function toString()
    {
        $queryParts = array(
            'DELETE',
            $this->buildFrom(),
            $this->buildJoin(),
            $this->buildWhere(),
        );

        return implode(' ', array_filter($queryParts));
    }

    public function from($table, $alias = null)
    {
        $this->from = new Snippets\From($table, $alias);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    private function buildFrom()
    {
        if(!$this->from instanceof Snippet)
        {
            throw new \LogicException('No column for FROM clause');
        }

        return $this->from->toString();
    }

    private function buildWhere()
    {
        $this->where->setEscaper($this->escaper);

        return $this->where->toString();
    }
}
