<?php

namespace Mdd\QueryBuilder\Types;

class String extends AbstractType
{
    protected function format($value)
    {
        return $this->escaper->escape($value);
    }
}