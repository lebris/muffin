<?php

namespace Muffin\Conditions;

class NotLike extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return 'NOT LIKE';
    }
}
