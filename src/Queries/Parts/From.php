<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class From implements PartBuilder
{
    private
        $tableName;

    public function __construct($tableName, $alias = null)
    {
        if(empty($tableName))
        {
            throw new \InvalidArgumentException('Empty table name.');
        }

        $this->tableName = new TableName($tableName, $alias);
    }

    public function toString()
    {
        return sprintf('FROM %s', $this->tableName->toString());
    }
}