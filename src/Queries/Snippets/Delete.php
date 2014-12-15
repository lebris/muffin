<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class Delete implements Snippet
{
    private
        $tableName;

    public function __construct($tableName)
    {
        $this->tableName = new TableName($tableName);
    }

    public function toString()
    {
        $from = new From($this->tableName);

        return sprintf('DELETE %s', $from->toString());
    }
}
