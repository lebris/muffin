<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Set implements Snippet
{
    use EscaperAware;

    private
        $sets;

    public function __construct()
    {
        $this->sets = array();
    }

    public function set(array $fields)
    {
        $this->sets = array_merge($this->sets, $fields);

        return $this;
    }

    public function toString()
    {
        if(empty($this->sets))
        {
            return '';
        }

        $sets = array();
        foreach($this->sets as $column => $value)
        {
            if(! $value instanceof Type)
            {
                $value = new Types\String($value);
            }

            $sets[] = (new Conditions\Equal($column, $value))->toString($this->escaper);
        }

        return sprintf('SET %s', implode(', ', $sets));
    }
}