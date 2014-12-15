<?php

namespace Mdd\QueryBuilder\Types;

class Boolean extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    protected function format($value)
    {
        return (int) ((bool) $value);
    }
}
