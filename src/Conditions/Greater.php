<?php

namespace Muffin\Conditions;

class Greater extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '>';
    }
}
