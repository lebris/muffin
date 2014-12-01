<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\PartBuilders;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Select implements Query
{
    use EscaperAware;

    private
        $conditions,
        $select,
        $from;

    public function __construct($columns = null)
    {
        $this->select = new Parts\Select();
        $this->where = new Parts\Where();

        $this->select->select($columns);
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildSelect(),
            $this->buildFrom(),
            $this->buildWhere(),
        );

        return implode(' ', array_filter($queryParts));
    }

    public function from($table, $alias = null)
    {
        $this->from = new Parts\From($table, $alias);

        return $this;
    }

    public function select($columns)
    {
        $this->select->select($columns);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->where->where($condition);

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
        $this->where->setEscaper($this->escaper);

        return $this->where->toString();
    }
}