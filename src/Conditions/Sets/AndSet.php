<?php

namespace Muffin\Conditions\Sets;

use Muffin\Condition;

class AndSet extends AbstractSet
{
    protected function joinConditions(Condition $leftCondition, Condition $rightCondition)
    {
        return $leftCondition->and($rightCondition);
    }
}
