<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class GroupBy implements Snippet
{
    private
        $groupBy;

    public function __construct()
    {
        $this->groupBy = array();
    }

    public function addGroupBy($column)
    {
        if(!empty($column))
        {
            $this->groupBy[$column] = $column;
        }

        return $this;
    }

    public function toString()
    {
        if(empty($this->groupBy))
        {
            return '';
        }

        return sprintf('GROUP BY %s', implode(', ', $this->groupBy));
    }
}
