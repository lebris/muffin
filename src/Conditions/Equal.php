<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Equal implements Condition
{
    use EscaperAware;

    private
        $column,
        $type;

    public function __construct($column, Type $type)
    {
        $this->column = (string) $column;
        $this->type = $type;
    }

    public function toString()
    {
        $value = $this->getEscapedValue();

        if(empty($this->column))
        {
            return '';
        }

        return sprintf('%s = %s', $this->column, $value);
    }

    private function getEscapedValue()
    {
        $value = $this->type->getValue();

        if($this->type->isEscapeRequired())
        {
            $value = $this->escaper->escape($value);
        }

        return $value;
    }
}