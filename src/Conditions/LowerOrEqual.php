<?php

namespace Mdd\QueryBuilder\Conditions;

class LowerOrEqual extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '<=';
    }
}
