<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

abstract class AbstractInCondition extends AbstractCondition
{
    protected
        $type,
        $values;

    public function __construct($column, array $values)
    {
        $this->type = $column;
        $this->values = $values;
    }

    public function toString(Escaper $escaper)
    {
        if(empty($this->type))
        {
            return '';
        }

        $values = $this->escapeValues($this->values, $escaper);

        return sprintf(
            '%s %s (%s)',
            $this->type->getName(),
            $this->getOperator(),
            implode(', ', $values)
        );
    }

    public function isEmpty()
    {
        return empty($this->type->getName());
    }

    abstract protected function getOperator();

    protected function escapeValues(array $values, Escaper $escaper)
    {
        $escapedValues = array();

        foreach($values as $value)
        {
            $formatedValue = $this->type->format($value);
            if($this->type->isEscapeRequired())
            {
                $formatedValue = $escaper->escape($formatedValue);
            }

            $escapedValues[] = $formatedValue;
        }

        return $escapedValues;
    }
}
