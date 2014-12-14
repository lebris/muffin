<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class Insert implements PartBuilder
{
    private
        $tableName;

    public function __construct($table)
    {
        if(! $table instanceof TableName)
        {
            $table = new TableName($table);
        }

        $this->tableName = $table;
    }

    public function toString()
    {
        return sprintf('INSERT INTO %s', $this->tableName->toString());
    }
}