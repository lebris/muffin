<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class Select implements Snippet
{
    private
        $columns;

    public function __construct($columns = array())
    {
        $this->columns = array();

        $this->addColumns($columns);
    }

    public function select($columns)
    {
        $this->addColumns($columns);

        return $this;
    }

    public function toString()
    {
        if(empty($this->columns))
        {
            throw new \LogicException('No columns defined for SELECT clause');
        }

        return sprintf('SELECT %s', implode(', ', $this->columns));
    }

    private function addColumns($columns)
    {
        $columns = array_filter($this->ensureIsArray($columns));

        foreach($columns as $column)
        {
            if(! is_string($column))
            {
                throw new \InvalidArgumentException('Column name must be a string.');
            }
        }

        $this->columns = array_unique(array_merge($this->columns, $columns));
    }

    private function ensureIsArray($select)
    {
        if(! is_array($select))
        {
            $select = array($select);
        }

        return $select;
    }
}
