<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;
use Muffin\Condition;
use Muffin\Traits\EscaperAware;

class Where implements Snippet
{
    use EscaperAware;

    private
        $conditions;

    public function __construct(Condition $condition = null)
    {
        $this->conditions = array();

        if($condition instanceof Condition)
        {
            $this->addCondition($condition);
        }
    }

    public function where(Condition $condition)
    {
        $this->addCondition($condition);

        return $this;
    }

    public function toString()
    {
        $conditionString = $this->buildConditionString();
        if(empty($conditionString))
        {
            return '';
        }

        return sprintf('WHERE %s', $conditionString);
    }

    private function buildConditionString()
    {
        $whereConditions = array();
        foreach($this->conditions as $condition)
        {
            $conditionString = $condition->toString($this->escaper);
            if(! empty($conditionString))
            {
                $whereConditions[] = $conditionString;
            }
        }

        return implode(' AND ', $whereConditions);
    }

    private function addCondition(Condition $condition)
    {
        $this->conditions[] = $condition;
    }
}
