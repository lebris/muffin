<?php

namespace Mdd\QueryBuilder\Conditions\Sets;

use Mdd\QueryBuilder\Condition;

class OrSet extends AbstractSet
{
    protected function joinConditions(Condition $leftCondition, Condition $rightCondition)
    {
        return $leftCondition->or($rightCondition);
    }
}
