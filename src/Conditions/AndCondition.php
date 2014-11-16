<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;

class AndCondition extends AbstractCompositeCondition
{
    protected function buildCondition()
    {
        return sprintf(
            '(%s AND %s)',
            $this->leftCondition->toString(),
            $this->rightCondition->toString()
        );
    }
}