<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Escaper;

class Having implements Snippet
{
    use
        EscaperAware;

    private
        $condition;

    public function __construct()
    {
        $this->condition = new Conditions\NullCondition();
    }

    public function having(Condition $condition)
    {
        $this->addCondition($condition);

        return $this;
    }

    public function toString()
    {
        if($this->condition->isEmpty())
        {
            return '';
        }

        return sprintf('HAVING %s', $this->condition->toString($this->escaper));
    }

    private function addCondition(Condition $condition)
    {
        $this->condition = $this->condition->and($condition);
    }
}
