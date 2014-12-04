<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

class Different extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '!=';
    }
}
