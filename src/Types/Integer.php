<?php

namespace Mdd\QueryBuilder\Types;

class Integer extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    protected function format($value)
    {
        return (int) $value;
    }
}