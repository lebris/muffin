<?php

namespace Mdd\QueryBuilder\Conditions;

class Different extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '!=';
    }
}
