<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Escaper;

class Equal extends AbstractCondition
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

    public function toString(Escaper $escaper)
    {
        $value = $this->escapeValue($this->type->getValue(), $escaper);

        if(empty($this->column))
        {
            return '';
        }

        return sprintf('%s = %s', $this->column, $value);
    }

    private function escapeValue($value, Escaper $escaper)
    {
        if($this->type->isEscapeRequired())
        {
            $value = $escaper->escape($value);
        }

        return $value;
    }
}