<?php

namespace Mdd\QueryBuilder\Queries\Parts;

use Mdd\QueryBuilder\PartBuilder;

class Update implements PartBuilder
{
    private
        $tables;

    public function __construct($table = null, $alias = null)
    {
        $this->tables = array();

        if(! empty($table))
        {
            $this->addTable($table, $alias);
        }
    }

    public function addTable($table, $alias = null)
    {
        if(! $table instanceof TableName)
        {
            $table = new TableName($table, $alias);
        }

        $this->tables[] = $table;

        return $this;
    }

    public function toString()
    {
        if(empty($this->tables))
        {
            return '';
        }

        $tables = array();

        foreach($this->tables as $table)
        {
            $tables[] = $table->toString();
        }

        $tablesString = implode(', ', array_filter($tables));

        return sprintf('UPDATE %s', $tablesString);
    }
}