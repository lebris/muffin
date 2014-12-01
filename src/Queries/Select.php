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
    use EscaperAware;

    private
        $conditions,
        $select,
        $innerJoins,
        $from;

    public function __construct($columns = null)
    {
        $this->select = new Parts\Select();
        $this->innerJoins = array();
        $this->where = new Parts\Where();

        $this->select->select($columns);
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildSelect(),
            $this->buildFrom(),
            $this->buildJoin(),
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

    public function innerJoin($table, $alias = null)
    {
        $this->innerJoins[] = new Parts\InnerJoin($table, $alias);

        return $this;
    }

    public function on($leftColumn, $rightColumn)
    {
        $innerJoin = $this->getLastInnerJoin();
        $innerJoin->on($leftColumn, $rightColumn);

        return $this;
    }

    public function using($column)
    {
        $innerJoin = $this->getLastInnerJoin();
        $innerJoin->using($column);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    /**
     * @return Parts\InnerJoin
     */
    private function getLastInnerJoin()
    {
        $lastInnerJoins = end($this->innerJoins);

        if(! $lastInnerJoins instanceof Parts\InnerJoin)
        {
            throw new \LogicException('Erreur dans la récupération de la dernière jointure');
        }

        return $lastInnerJoins;
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

    private function buildJoin()
    {
        $joins = array();

        foreach($this->innerJoins as $innerJoin)
        {
            $joins[] = $innerJoin->toString();
        }

        return implode(' ', $joins);
    }
}