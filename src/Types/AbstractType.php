<?php

namespace Mdd\QueryBuilder\Types;

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Traits\EscaperAware;

abstract class AbstractType implements Type
{
    use EscaperAware;

    private
        $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->format($this->value);
    }

    abstract protected function format($value);
}