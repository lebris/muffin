<?php

namespace Mdd\QueryBuilder\Conditions\Sets;

use Mdd\QueryBuilder\Condition;

class AndSet extends AbstractSet
{
    protected function joinConditions(Condition $leftCondition, Condition $rightCondition)
    {
        return $leftCondition->and($rightCondition);
    }
}
