<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class Greater extends AbstractCondition
{
    protected function buildConditionString(Escaper $escaper)
    {
        $value = $this->escapeValue($this->type->getValue(), $escaper);

        if(empty($this->column))
        {
            return '';
        }

        return sprintf('%s > %s', $this->column, $value);
    }
}