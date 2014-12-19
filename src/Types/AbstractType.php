<?php

namespace Muffin\Types;

use Muffin\Type;
use Muffin\Conditions;

abstract class AbstractType implements Type
{
    private
        $name;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function equal($value)
    {
        return new Conditions\Equal($this, $value);
    }

    public function different($value)
    {
        return new Conditions\Different($this, $value);
    }

    public function like($value)
    {
        return new Conditions\Like($this, $value);
    }

    public function greaterThan($value)
    {
        return new Conditions\Greater($this, $value);
    }

    public function greaterOrEqualThan($value)
    {
        return new Conditions\GreaterOrEqual($this, $value);
    }

    public function lowerThan($value)
    {
        return new Conditions\Lower($this, $value);
    }

    public function lowerOrEqualThan($value)
    {
        return new Conditions\LowerOrEqual($this, $value);
    }

    public function between($start, $end)
    {
        return new Conditions\Between($this, $start, $end);
    }

    public function in($value)
    {
        return new Conditions\In($this, $value);
    }

    public function isNull()
    {
        return new Conditions\IsNull($this);
    }

    public function notIn($value)
    {
        return new Conditions\NotIn($this, $value);
    }
}
