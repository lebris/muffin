<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;

class OrCondition extends AbstractCompositeCondition
{
    protected function buildCondition()
    {
        return sprintf(
            '%s OR %s',
            $this->leftCondition->toString(),
            $this->rightCondition->toString()
        );
    }
}