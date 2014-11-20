<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Conditions\CompositeCondition;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Escaper;

abstract class AbstractCompositeCondition implements CompositeCondition
{
    protected
        $leftCondition,
        $rightCondition;

    public function __construct(Condition $leftCondition, Condition $rightCondition)
    {
        $this->leftCondition = $leftCondition;
        $this->rightCondition = $rightCondition;
    }

    public function toString(Escaper $escaper)
    {
        return $this->buildCondition($escaper);
    }

    protected function buildPartCondition(Condition $condition, Escaper $escaper)
    {
        $partCondition = $condition->toString($escaper);

        if($condition instanceof CompositeCondition)
        {
            $partCondition = sprintf('(%s)', $partCondition);
        }

        return $partCondition;
    }

    abstract protected function buildCondition(Escaper $escaper);
}