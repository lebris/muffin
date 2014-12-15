<?php

namespace Mdd\QueryBuilder\Types;

use Mdd\QueryBuilder\Type;

abstract class AbstractType implements Type
{
    private
        $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->format($this->value);
    }

    abstract protected function format($value);
}
