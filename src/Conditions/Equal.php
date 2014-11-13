<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Type;

class Equal implements Condition
{
    private
        $column,
        $type;

    public function __construct($column, Type $type)
    {
        $this->column = (string) $column;
        $this->type = $type;
    }

    public function toString()
    {
        return sprintf('%s = %s', $this->column, $this->type->getValue());
    }
}