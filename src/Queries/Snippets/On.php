<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class On implements Snippet
{
    private
        $leftColumn,
        $rightColumn;

    public function __construct($leftColumn, $rightColumn)
    {
        $this->leftColumn = (string) $leftColumn;
        $this->rightColumn = (string) $rightColumn;
    }

    public function toString()
    {
        if(empty($this->leftColumn) || empty($this->rightColumn))
        {
            return '';
        }

        return sprintf(
            'ON %s = %s',
            $this->leftColumn,
            $this->rightColumn
        );
    }
}
