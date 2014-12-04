<?php

namespace Mdd\QueryBuilder\Conditions;

class Equal extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '=';
    }
}
