<?php

namespace Mdd\QueryBuilder\Conditions;

class GreaterOrEqual extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>=';
    }
}
