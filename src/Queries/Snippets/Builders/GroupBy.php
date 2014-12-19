<?php

namespace Muffin\Queries\Snippets\Builders;

trait GroupBy
{
    protected
        $groupBy;

    public function groupBy($column)
    {
        $this->groupBy->addGroupBy($column);

        return $this;
    }

    private function buildGroupBy()
    {
        return $this->groupBy->toString();
    }
}
