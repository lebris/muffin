<?php

namespace Mdd\QueryBuilder\Conditions\Binaries;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Conditions\AbstractCompositeCondition;

class OrCondition extends AbstractCompositeCondition
{
    protected function buildCondition(Escaper $escaper)
    {
        return sprintf(
            '%s OR %s',
            $this->buildPartCondition($this->leftCondition, $escaper),
            $this->buildPartCondition($this->rightCondition, $escaper)
        );
    }
}