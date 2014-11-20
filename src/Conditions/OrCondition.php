<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;

class OrCondition extends AbstractCompositeCondition
{
    protected function buildCondition(Escaper $escaper)
    {
        return sprintf(
            '%s OR %s',
            $this->leftCondition->toString($escaper),
            $this->rightCondition->toString($escaper)
        );
    }
}