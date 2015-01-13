<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

class IsNotNull extends AbstractCondition
{
    private
        $column;

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

        return sprintf('%s IS NOT NULL', $this->column);
    }

    public function isEmpty()
    {
        return empty($this->column);
    }
}
