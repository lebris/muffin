<?php

namespace Muffin\Conditions;

class Like extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return 'LIKE';
    }
}
