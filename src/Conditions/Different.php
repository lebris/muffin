<?php

namespace Muffin\Conditions;

class Different extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '!=';
    }
}
