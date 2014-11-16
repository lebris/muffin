<?php

namespace Mdd\QueryBuilder\PartBuilders;

use Mdd\QueryBuilder\PartBuilder;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Where implements PartBuilder
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
            $conditionString = $condition->toString();
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
