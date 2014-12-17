<?php

namespace Mdd\QueryBuilder\Types;

class Integer extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    public function format($value)
    {
        return (int) $value;
    }
}
