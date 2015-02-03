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

        return sprintf('SELECT %s', $this->buildColumnsString());
    }

    private function buildColumnsString()
    {
        $columns = array();

        foreach($this->columns as $column)
        {
            if($column instanceof Selectable)
            {
                $column = $column->toString();
            }

            $columns[] = $column;
        }

        return implode(', ', array_unique($columns));
    }

    private function addColumns($columns)
    {
        $columns = array_filter($this->ensureIsArray($columns));

        $this->validateColumns($columns);

        $this->columns = array_merge($this->columns, $columns);
    }

    private function validateColumns($columns)
    {
        foreach($columns as $column)
        {
            if(! is_string($column) && (!$column instanceof Selectable))
            {
                throw new \InvalidArgumentException('Column name must be a string.');
            }
        }
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
