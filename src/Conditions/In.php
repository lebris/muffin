<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

class In extends AbstractCondition
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
            '%s IN (%s)',
            $this->type->getName(),
            implode(', ', $values)
        );
    }

    public function isEmpty()
    {
        return empty($this->type->getName());
    }

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
