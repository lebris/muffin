<?php

namespace Mdd\QueryBuilder\Types;

class Float extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    protected function format($value)
    {
        return floatval($value);
    }
}
