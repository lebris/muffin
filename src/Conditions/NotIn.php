<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

class NotIn extends AbstractInCondition
{
    protected function getOperator()
    {
        return 'NOT IN';
    }
}
