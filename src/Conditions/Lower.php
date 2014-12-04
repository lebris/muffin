<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Escaper;

class Lower extends AbstractComparisonOperatorCondition
{
    protected function getConditionOperator()
    {
        return '<';
    }
}
