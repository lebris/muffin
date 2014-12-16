<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;

class NullCondition extends AbstractCondition
{
    public function toString(Escaper $escaper)
    {
        return '';
    }

    public function isEmpty()
    {
        return true;
    }
}
