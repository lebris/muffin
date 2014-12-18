<?php

namespace Mdd\QueryBuilder\Conditions;

class NotIn extends AbstractInCondition
{
    protected function getOperator()
    {
        return 'NOT IN';
    }
}
