<?php

namespace Mdd\QueryBuilder\Conditions;

class Lower extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '<';
    }
}
