<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

class IsNotNull extends AbstractNullComparisonCondition
{
    protected function getOperator()
    {
        return 'IS NOT NULL';
    }
}
