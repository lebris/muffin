<?php

namespace Mdd\QueryBuilder\Conditions;

use Mdd\QueryBuilder\Escaper;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Query;

class Statement extends AbstractCondition
{
    private
        $statement;

    public function __construct($statement)
    {
        $this->statement = $statement;
    }

    public function toString(Escaper $escaper)
    {
        if($this->isEmpty())
        {
            return '';
        }

        $statement = $this->statement;

        if($this->statement instanceof Query)
        {
            $this->statement->setEscaper($escaper);

            $statement = $this->wrapWithParenthese($this->statement->toString());
        }

        return (string) $statement;
    }

    private function wrapWithParenthese($value)
    {
        return sprintf('(%s)', $value);
    }

    public function isEmpty()
    {
        return empty($this->statement);
    }
}
