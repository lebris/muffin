<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

abstract class AbstractComparisonOperatorCondition extends AbstractCondition
{
    protected
        $type,
        $value;

    public function __construct(Type $column, $value)
    {
        $this->type = $column;
        $this->value = $value;
    }

    public function toString(Escaper $escaper)
    {
        if(empty($this->type->getName()))
        {
            return '';
        }

        return sprintf(
            '%s %s %s',
            $this->type->getName(),
            $this->getConditionOperator(),
            $this->escapeValue($this->value, $escaper)
        );
    }

    public function isEmpty()
    {
        return empty($this->type->getName());
    }

    abstract protected function getConditionOperator();

    private function escapeValue($value, Escaper $escaper)
    {
        $value = $this->type->format($value);

        if($this->type->isEscapeRequired())
        {
            $value = $escaper->escape($value);
        }

        return $value;
    }
}
