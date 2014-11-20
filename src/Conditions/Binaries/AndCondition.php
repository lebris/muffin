<?php

namespace Mdd\QueryBuilder\Conditions\Binaries;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Conditions\AbstractCompositeCondition;

class AndCondition extends AbstractCompositeCondition
{
    protected function buildCondition(Escaper $escaper)
    {
        return sprintf(
            '(%s AND %s)',
            $this->leftCondition->toString($escaper),
            $this->rightCondition->toString($escaper)
        );
    }
}