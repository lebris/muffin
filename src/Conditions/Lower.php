<?php

namespace Muffin\Conditions;

class Lower extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '<';
    }
}
