<?php

namespace Muffin\Conditions\Sets;

use Muffin\Conditions\AbstractCondition;
use Muffin\Conditions\CompositeCondition;
use Muffin\Escaper;
use Muffin\Condition;

abstract class AbstractSet extends AbstractCondition implements CompositeCondition
{
    private
    $conditions;

    public function __construct()
    {
        $this->conditions = array();
    }

    public function toString(Escaper $escaper)
    {
        if($this->isEmpty())
        {
            return '';
        }

        $condition = $this->buildCompositeCondition();

        return $condition->toString($escaper);
    }

    public function add(Condition $condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    public function isEmpty()
    {
        foreach($this->conditions as $condition)
        {
            if(! $condition->isEmpty())
            {
                return false;
            }
        }

        return true;
    }

    private function buildCompositeCondition()
    {
        $conditions = $this->getNotEmptyConditions();

        $compositeCondition = array_shift($conditions);

        foreach($conditions as $condition)
        {
            $compositeCondition = $this->joinConditions($compositeCondition, $condition);
        }

        return $compositeCondition;
    }

    private function getNotEmptyConditions()
    {
        return array_filter($this->conditions, function (Condition $item) {
            return $item->isEmpty() === false;
        });
    }

    abstract protected function joinConditions(Condition $leftCondition, Condition $rightCondition);
}
