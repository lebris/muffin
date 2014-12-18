<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Builders;

use Mdd\QueryBuilder\Queries\Snippets;

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
        if(!$this->limit instanceof Snippets\Limit)
        {
            throw new \LogicException('LIMIT is required to define OFFSET.');
        }

        $this->offset = new Snippets\Offset($offset);

        return $this;
    }

    private function buildLimit()
    {
        $limit = $this->buildLimitClause();

        $offset = '';
        if(! empty($limit))
        {
            $offset = $this->buildOffsetClause();
        }

        $clauses = array($limit, $offset);

        return implode(' ', array_filter($clauses));
    }

    private function buildLimitClause()
    {
        if($this->limit instanceof Snippets\Limit)
        {
            return $this->limit->toString();
        }
    }

    private function buildOffsetClause()
    {
        if($this->offset instanceof Snippets\Offset)
        {
            return $this->offset->toString();
        }
    }
}
