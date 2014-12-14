<?php

namespace Mdd\QueryBuilder\Queries\Parts;

trait Joinable
{
    protected
        $joins = array();

    public function innerJoin($table, $alias = null)
    {
        $this->joins[] = new Joins\InnerJoin($table, $alias);

        return $this;
    }

    public function leftJoin($table, $alias = null)
    {
        $this->joins[] = new Joins\LeftJoin($table, $alias);

        return $this;
    }

    public function rightJoin($table, $alias = null)
    {
        $this->joins[] = new Joins\RightJoin($table, $alias);

        return $this;
    }

    public function on($leftColumn, $rightColumn)
    {
        $join = $this->getLastJoin();
        $join->on($leftColumn, $rightColumn);

        return $this;
    }

    protected function buildJoin()
    {
        $joins = array();

        foreach($this->joins as $innerJoin)
        {
            $joins[] = $innerJoin->toString();
        }

        return implode(' ', $joins);
    }

    private function getLastJoin()
    {
        $lastJoins = end($this->joins);

        if(! $lastJoins instanceof Join)
        {
            throw new \LogicException('Erreur dans la récupération de la dernière jointure');
        }

        return $lastJoins;
    }
}