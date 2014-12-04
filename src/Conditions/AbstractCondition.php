<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Type;

abstract class AbstractCondition implements Condition
{
    protected
        $column,
        $type;

    public function __construct($column, Type $type)
    {
        $this->column = (string) $column;
        $this->type = $type;
    }

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

    public function toString(Escaper $escaper)
    {
        if(empty($this->column))
        {
            return '';
        }

        return $this->buildConditionString($escaper);
    }

    abstract protected function buildConditionString(Escaper $escaper);

    protected function escapeValue($value, Escaper $escaper)
    {
        if($this->type->isEscapeRequired())
        {
            $value = $escaper->escape($value);
        }

        return $value;
    }
}