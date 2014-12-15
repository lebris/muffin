<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Builders;

use Mdd\QueryBuilder\Queries\Snippets;

trait Limit
{
    protected
        $limit;

    public function limit($limit, $offset = null)
    {
        $this->limit = new Snippets\Limit($limit, $offset);

        return $this;
    }

    private function buildLimit()
    {
        if($this->limit instanceof Snippets\Limit)
        {
            return $this->limit->toString();
        }
    }
}
