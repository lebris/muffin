<?php

namespace Mdd\QueryBuilder\Conditions\Binaries;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Conditions\CompositeCondition;

class AndCondition extends AbstractCompositeCondition
{
    protected function buildCondition(Escaper $escaper)
    {
        return sprintf(
            '%s AND %s',
            $this->buildPartCondition($this->leftCondition, $escaper),
            $this->buildPartCondition($this->rightCondition, $escaper)
        );
    }
}