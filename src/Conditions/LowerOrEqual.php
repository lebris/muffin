<?php

namespace Muffin\Conditions;

class LowerOrEqual extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '<=';
    }
}
