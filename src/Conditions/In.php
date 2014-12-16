<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

class In extends AbstractCondition
{
    protected
        $column,
        $types;

    public function __construct($column, array $types)
    {
        $this->column = (string) $column;
        $this->types = $types;
    }

    public function toString(Escaper $escaper)
    {
        if(empty($this->column))
        {
            return '';
        }

        $values = $this->escapeValues($this->types, $escaper);

        return sprintf(
            '%s IN (%s)',
            $this->column,
            implode(', ', $values)
        );
    }

    public function isEmpty()
    {
        return empty($this->column);
    }

    protected function escapeValues(array $types, Escaper $escaper)
    {
        $escapedValues = array();

        foreach($types as $type)
        {
            $value = $type->getValue();
            if($type->isEscapeRequired())
            {
                $value = $escaper->escape($value);
            }

            $escapedValues[] = $value;
        }

        return $escapedValues;
    }
}
