<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\Snippet;

class From implements Snippet
{
    private
        $tableName;

    public function __construct($table, $alias = null)
    {
        if(! $table instanceof TableName)
        {
            $table = new TableName($table, $alias);
        }

        $this->tableName = $table;
    }

    public function toString()
    {
        return sprintf('FROM %s', $this->tableName->toString());
    }
}