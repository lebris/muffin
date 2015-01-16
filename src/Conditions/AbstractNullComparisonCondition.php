<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

abstract class AbstractNullComparisonCondition extends AbstractCondition
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

        return sprintf('%s %s',
            $this->column,
            $this->getOperator()
        );
    }

    public function isEmpty()
    {
        return empty($this->column);
    }

    abstract protected function getOperator();
}
