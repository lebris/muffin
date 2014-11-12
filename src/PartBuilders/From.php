<?php

namespace Mdd\QueryBuilder\PartBuilders;

use Mdd\QueryBuilder\PartBuilder;

class From implements PartBuilder
{
    private
        $tableName;

    public function __construct($tableName)
    {
        if(empty($tableName))
        {
            throw new \InvalidArgumentException('Empty table name.');
        }

        if(! is_string($tableName))
        {
            throw new \InvalidArgumentException('Table name must be a string');
        }

        $this->tableName = $tableName;
    }

    public function toString()
    {
        return sprintf('FROM %s', $this->tableName);
    }
}