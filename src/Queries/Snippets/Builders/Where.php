<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Builders;

use Mdd\QueryBuilder\Queries\Snippets;
use Mdd\QueryBuilder\Condition;

trait Where
{
    protected
        $where;

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    private function buildWhere()
    {
        $this->where->setEscaper($this->escaper);

        return $this->where->toString();
    }
}
