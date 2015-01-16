<?php

namespace Muffin\Conditions;

class IsNull extends AbstractNullComparisonCondition
{
    protected function getOperator()
    {
        return 'IS NULL';
    }
}
