<?php

namespace Mdd\QueryBuilder\Types;

use Mdd\QueryBuilder\Type;

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
}
