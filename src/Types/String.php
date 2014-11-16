<?php

namespace Mdd\QueryBuilder\Types;

class String extends AbstractType
{
    public function isEscapeRequired()
    {
        return true;
    }

    protected function format($value)
    {
        return (string) $value;
    }
}