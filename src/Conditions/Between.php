<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Conditions\AbstractCondition;
use Mdd\QueryBuilder\Escaper;

class Between extends AbstractCondition
{
    protected
        $type,
        $start,
        $end;

    public function __construct($column, $start, $end)
    {
        $this->type = $column;
        $this->start = $start;
        $this->end = $end;
    }

    public function toString(Escaper $escaper)
    {
        if($this->isEmpty())
        {
            return '';
        }

        return sprintf(
            '%s BETWEEN %s AND %s',
            $this->type->getName(),
            $this->escapeValue($this->start, $escaper),
            $this->escapeValue($this->end, $escaper)
        );
    }

    public function isEmpty()
    {
        $columnName = $this->type->getName();
        if(empty($columnName) || empty($this->start) || empty($this->end))
        {
            return true;
        }

        return false;
    }

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
