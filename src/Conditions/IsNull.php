<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class IsNull extends AbstractCondition
{
    private
        $column;

    public function __construct($column)
    {
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
}