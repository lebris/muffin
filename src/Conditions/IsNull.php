<?php

namespace Muffin\Conditions;

use Muffin\Escaper;
use Muffin\Type;

class IsNull extends AbstractNullComparisonCondition
{
    protected function getOperator()
    {
        return 'IS NULL';
    }
}
