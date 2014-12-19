<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;
use Muffin\Condition;
use Muffin\Conditions;
use Muffin\Traits\EscaperAware;
use Muffin\Escaper;

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
