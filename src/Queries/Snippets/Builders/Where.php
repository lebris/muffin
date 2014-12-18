<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Builders;

use Mdd\QueryBuilder\Queries\Snippets;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;

trait Where
{
    protected
        $where;

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    private function buildWhere(Escaper $escaper)
    {
        $this->where->setEscaper($escaper);

        return $this->where->toString();
    }
}
