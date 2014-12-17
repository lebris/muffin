<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

class IsNull extends AbstractCondition
{
    public function __construct($column)
    {
        if($column instanceof Type)
        {
            $column = $column->getName();
        }

        $this->column = (string) $column;
    }

    public function toString(Escaper $escaper)
    {
        if(empty($this->column))
        {
            return '';
        }

        return sprintf('%s IS NULL', $this->column);
    }

    public function isEmpty()
    {
        return empty($this->column);
    }
}
