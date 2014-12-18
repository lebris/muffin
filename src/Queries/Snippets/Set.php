<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Traits\TypeGuesser;

class Set implements Snippet
{
    use
        EscaperAware,
        TypeGuesser;

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
        foreach($this->sets as $columnName => $value)
        {
            $type = $this->guessType($columnName, $value);

            $sets[] = (new Conditions\Equal($type, $value))->toString($this->escaper);
        }

        return sprintf('SET %s', implode(', ', $sets));
    }
}
