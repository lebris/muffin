<?php

namespace Muffin\Conditions;

class In extends AbstractInCondition
{
    protected function getOperator()
    {
        return 'IN';
    }
}
