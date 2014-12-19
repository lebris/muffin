<?php

namespace Muffin\Conditions\Binaries;

use Muffin\Conditions\CompositeCondition;
use Muffin\Condition;
use Muffin\Escaper;
use Muffin\Conditions\AbstractCondition;

abstract class AbstractCompositeCondition extends AbstractCondition implements CompositeCondition
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
        if($this->leftCondition->isEmpty())
        {
            return $this->rightCondition->toString($escaper);
        }

        if($this->rightCondition->isEmpty())
        {
            return $this->leftCondition->toString($escaper);
        }

        return $this->buildCondition($escaper);
    }

    public function isEmpty()
    {
        return $this->leftCondition->isEmpty() && $this->rightCondition->isEmpty();
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
