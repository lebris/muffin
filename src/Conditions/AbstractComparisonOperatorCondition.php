<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

abstract class AbstractComparisonOperatorCondition extends AbstractCondition
{
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
