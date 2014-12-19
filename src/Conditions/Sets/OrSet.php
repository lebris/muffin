<?php

namespace Muffin\Conditions\Sets;

use Muffin\Condition;

class OrSet extends AbstractSet
{
    protected function joinConditions(Condition $leftCondition, Condition $rightCondition)
    {
        return $leftCondition->or($rightCondition);
    }
}
