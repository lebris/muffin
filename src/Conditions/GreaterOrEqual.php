<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class GreaterOrEqual extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>=';
    }
}
