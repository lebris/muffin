<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class Distinct implements Snippet
{
    private
        $columnName;

    public function __construct($columnName)
    {
        if(empty($columnName))
        {
            throw new \InvalidArgumentException('Empty column name.');
        }

        $this->columnName = (string) $columnName;
    }

    public function toString()
    {
        return sprintf('DISTINCT %s', $this->columnName);
    }
}
