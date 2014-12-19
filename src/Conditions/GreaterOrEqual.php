<?php

namespace Muffin\Conditions;

class GreaterOrEqual extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>=';
    }
}
