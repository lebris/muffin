<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Builders;

use Mdd\QueryBuilder\Queries\Snippets;
use Mdd\QueryBuilder\Snippet;

trait Limit
{
    protected
        $limit,
        $offset;

    public function limit($limit)
    {
        $this->limit = new Snippets\Limit($limit);

        return $this;
    }

    public function offset($offset)
    {
        $this->offset = new Snippets\Offset($offset);

        return $this;
    }

    private function buildLimitAndOffset()
    {
        $clause = array(
            $this->buildLimit(),
            $this->buildOffsetClause(),
        );


        if(! empty($clause))
        {
            $clause .= $this->buildOffsetClause();
        }

        return $clause;
    }

    private function buildLimit()
    {
        if($this->limit instanceof Snippets\Limit)
        {
            $clause = $this->limit->toString();
        }
    }

    private function buildOffsetClause()
    {
        if($this->offset instanceof Snippets\Offset)
        {
            return ' ' . $this->offset->toString();
        }
    }
}
