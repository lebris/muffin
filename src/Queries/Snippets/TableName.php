<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class TableName implements Snippet
{
    private
        $tableName,
        $alias;

    public function __construct($tableName, $alias = null)
    {
        if(empty($tableName))
        {
            throw new \InvalidArgumentException('Empty table name.');
        }

        $this->tableName = $tableName;

        $this->alias = (string) $alias;
    }

    public function toString()
    {
        if(empty($this->alias))
        {
            return $this->tableName;
        }

        return sprintf('%s AS %s', $this->tableName, $this->alias);
    }
}