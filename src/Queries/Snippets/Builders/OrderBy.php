<?php

namespace Muffin\Queries\Snippets\Builders;

use Muffin\Queries\Snippets;

trait OrderBy
{
    protected
        $orderBy;

    public function orderBy($column, $directrion = Snippets\OrderBy::ASC)
    {
        $this->orderBy->addOrderBy($column, $directrion);

        return $this;
    }

    private function buildOrderBy()
    {
        return $this->orderBy->toString();
    }
}
