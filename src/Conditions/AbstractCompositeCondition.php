<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Conditions\CompositeCondition;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;

abstract class AbstractCompositeCondition implements CompositeCondition
{
    use EscaperAware;

    protected
        $leftCondition,
        $rightCondition;

    public function __construct(Condition $leftCondition, Condition $rightCondition)
    {
        $this->leftCondition = $leftCondition;
        $this->rightCondition = $rightCondition;
    }

    public function toString()
    {
        $this->leftCondition->setEscaper($this->escaper);
        $this->rightCondition->setEscaper($this->escaper);

        return $this->buildCondition();
    }

    abstract protected function buildCondition();
}