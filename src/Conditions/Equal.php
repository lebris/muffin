<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class Equal extends AbstractCondition
{
    protected function buildConditionString(Escaper $escaper)
    {
        $value = $this->escapeValue($this->type->getValue(), $escaper);

        return sprintf('%s = %s', $this->column, $value);
    }
}