<?php

namespace Muffin\Conditions;

class IsNotNull extends AbstractNullComparisonCondition
{
    protected function getOperator()
    {
        return 'IS NOT NULL';
    }
}
