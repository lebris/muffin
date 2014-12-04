<?php

namespace Mdd\QueryBuilder\Conditions;

class Greater extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>';
    }
}
