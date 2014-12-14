<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\PartBuilders;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\PartBuilder;

class Select implements Query
{
    use Parts\Joinable;
    use EscaperAware;

    private
        $select,
        $from,
        $where,
        $orderBy,
        $groupBy,
        $limit;

    public function __construct($columns = null)
    {
        $this->select = new Parts\Select();
        $this->where = new Parts\Where();
        $this->groupBy = new Parts\GroupBy();
        $this->orderBy = new Parts\OrderBy();

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
        $this->from = new Parts\From($table, $alias);

        return $this;
    }

    public function select($columns)
    {
        $this->select->select($columns);

        return $this;
    }

    public function using($column)
    {
        $join = $this->getLastJoin();
        $join->using($column);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    public function groupBy($column)
    {
        $this->groupBy->addGroupBy($column);

        return $this;
    }

    public function orderBy($column, $directrion = Parts\OrderBy::ASC)
    {
        $this->orderBy->addOrderBy($column, $directrion);

        return $this;
    }

    public function limit($limit, $offset = null)
    {
        $this->limit = new Parts\Limit($limit, $offset);

        return $this;
    }

    private function buildSelect()
    {
        return $this->select->toString();
    }

    private function buildFrom()
    {
        if(!$this->from instanceof PartBuilder)
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

    private function buildGroupBy()
    {
        return $this->groupBy->toString();
    }

    private function buildOrderBy()
    {
        return $this->orderBy->toString();
    }

    private function buildLimit()
    {
        if($this->limit instanceof Parts\Limit)
        {
            return $this->limit->toString();
        }
    }
}