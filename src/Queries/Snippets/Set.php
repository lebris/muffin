<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;
use Muffin\Type;
use Muffin\Types;
use Muffin\Conditions;
use Muffin\Traits\EscaperAware;
use Muffin\Traits\TypeGuesser;

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
