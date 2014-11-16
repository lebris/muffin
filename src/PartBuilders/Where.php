<?php

namespace Mdd\QueryBuilder\PartBuilders;

use Mdd\QueryBuilder\PartBuilder;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Where implements PartBuilder
{
    use EscaperAware;

    private
        $condition;

    public function __construct(Condition $condition)
    {
        $this->condition = $condition;
    }

    public function toString()
    {
        $conditionString = $this->condition->toString();
        if(empty($conditionString))
        {
            return '';
        }

        return sprintf('WHERE %s', $conditionString);
    }
}
