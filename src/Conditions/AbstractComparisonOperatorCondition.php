<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

abstract class AbstractComparisonOperatorCondition extends AbstractCondition
{
    protected
        $column,
        $type;

    public function __construct($column, Type $type)
    {
        $this->column = (string) $column;
        $this->type = $type;
    }

    public function toString(Escaper $escaper)
    {
        if(empty($this->column))
        {
            return '';
        }

        return sprintf(
            '%s %s %s',
            $this->column,
            $this->getConditionOperator(),
            $this->escapeValue($this->type->getValue(), $escaper)
        );
    }

    public function isEmpty()
    {
        return empty($this->column);
    }

    abstract protected function getConditionOperator();

    private function escapeValue($value, Escaper $escaper)
    {
        if($this->type->isEscapeRequired())
        {
            $value = $escaper->escape($value);
        }

        return $value;
    }
}
