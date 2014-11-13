<?php

namespace Mdd\QueryBuilder\Types;

class Int extends AbstractType
{
    protected function format($value)
    {
        return (int) $value;
    }
}