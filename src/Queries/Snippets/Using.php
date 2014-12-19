<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class Using implements Snippet
{
    private
        $columns;

    public function __construct($column)
    {
        $this->columns = $this->ensureIsArray($column);
    }

    public function toString()
    {
        $usingColumns = implode(', ', array_filter($this->columns));
        if(empty($usingColumns))
        {
            return '';
        }

        return sprintf(
            'USING (%s)',
            $usingColumns
        );
    }

    private function ensureIsArray($input)
    {
        if(! is_array($input))
        {
            $input = array($input);
        }

        return $input;
    }
}
