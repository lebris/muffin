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
        Builders\Join,
        Builders\Where,
        Builders\OrderBy,
        Builders\Limit;

    private
        $from;

    public function __construct($table = null, $alias = null)
    {
        if(!empty($table))
        {
            $this->from($table, $alias);
        }

        $this->where = new Snippets\Where();
        $this->orderBy = new Snippets\OrderBy();
    }

    public function toString()
    {
        $queryParts = array(
            'DELETE',
            $this->buildFrom(),
            $this->buildJoin(),
            $this->buildWhere($this->escaper),
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

    private function buildFrom()
    {
        if(!$this->from instanceof Snippet)
        {
            throw new \LogicException('No column for FROM clause');
        }

        return $this->from->toString();
    }
}
