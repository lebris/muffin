<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

abstract class AbstractInCondition extends AbstractCondition
{
    protected
        $type,
        $values;

    public function __construct(Type $column, array $values)
    {
        $this->type = $column;
        $this->values = $values;
    }

    public function toString(Escaper $escaper)
    {
        if($this->isEmpty())
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
        $columnName = $this->type->getName();

        return empty($columnName);
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
