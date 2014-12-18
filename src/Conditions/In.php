<?php

namespace Mdd\QueryBuilder\Conditions;

class In extends AbstractInCondition
{
    protected function getOperator()
    {
        return 'IN';
    }
}
