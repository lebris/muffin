<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

class Different extends AbstractCondition
{
    protected function buildConditionString(Escaper $escaper)
    {
        $value = $this->escapeValue($this->type->getValue(), $escaper);

        if(empty($this->column))
        {
            return '';
        }

        return sprintf('%s != %s', $this->column, $value);
    }
}