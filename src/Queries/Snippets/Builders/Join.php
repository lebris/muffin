<?php

namespace Muffin\Queries\Snippets\Builders;

use Muffin\Queries\Snippets;

trait Join
{
    protected
        $joins = array();

    public function innerJoin($table, $alias = null)
    {
        $this->joins[] = new Snippets\Joins\InnerJoin($table, $alias);

        return $this;
    }

    public function leftJoin($table, $alias = null)
    {
        $this->joins[] = new Snippets\Joins\LeftJoin($table, $alias);

        return $this;
    }

    public function rightJoin($table, $alias = null)
    {
        $this->joins[] = new Snippets\Joins\RightJoin($table, $alias);

        return $this;
    }

    public function on($leftColumn, $rightColumn)
    {
        $join = $this->getLastJoin();
        $join->on($leftColumn, $rightColumn);

        return $this;
    }

    public function using($column)
    {
        $join = $this->getLastJoin();
        $join->using($column);

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

        if(! $lastJoins instanceof Snippets\Join)
        {
            throw new \LogicException('Erreur dans la récupération de la dernière jointure');
        }

        return $lastJoins;
    }
}
