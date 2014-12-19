<?php

namespace Muffin\Conditions;

use Muffin\Escaper;

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
