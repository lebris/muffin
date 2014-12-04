<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class Greater extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>';
    }
}
