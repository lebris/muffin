<?php

namespace Muffin\Conditions;

class Equal extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '=';
    }
}
