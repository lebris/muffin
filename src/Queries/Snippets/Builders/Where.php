<?php

namespace Muffin\Queries\Snippets\Builders;

use Muffin\Condition;
use Muffin\Escaper;

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
