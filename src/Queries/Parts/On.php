<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class On implements PartBuilder
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