<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;

abstract class AbstractCondition implements Condition
{
    public function _and(Condition $condition)
    {
        return new Binaries\AndCondition($this, $condition);
    }

    public function _or(Condition $condition)
    {
        return new Binaries\OrCondition($this, $condition);
    }

    public function __call($methodName, $arguments)
    {
        $method = '_' . $methodName;

        if(method_exists($this, $method))
        {
            if(array_key_exists(0, $arguments))
            {
                return $this->$method($arguments[0]);
            }

            throw new \RuntimeException(sprintf("Missing parameter 1 for %s", $method));
        }

        throw new \LogicException(sprintf("Unkown method %s", $method));
    }
}