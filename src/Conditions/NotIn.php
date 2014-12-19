<?php

namespace Muffin\Conditions;

class NotIn extends AbstractInCondition
{
    protected function getOperator()
    {
        return 'NOT IN';
    }
}
