<?php

namespace Mdd\QueryBuilder\Conditions;

class Like extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return 'LIKE';
    }
}
