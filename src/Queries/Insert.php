<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\Traits\EscaperAware;

class Insert implements Query
{
    use EscaperAware;

    private
        $insertPart,
        $valuesPart;

    public function __construct($table = null)
    {
        $this->valuesPart = new Parts\Values();

        if(! empty($table))
        {
            $this->insertPart = new Parts\TableName($table);
        }
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildInsertString(),
            $this->buildValuesString(),
        );

        return implode(' ', $queryParts);
    }

    public function insert($table)
    {
        $this->insertPart = new Parts\TableName($table);

        return $this;
    }

    public function values(array $values)
    {
        $this->valuesPart->values($values);

        return $this;
    }

    private function buildInsertString()
    {
        return sprintf('INSERT INTO %s', $this->insertPart->toString());
    }

    private function buildValuesString()
    {
        $this->valuesPart->setEscaper($this->escaper);

        return $this->valuesPart->toString();
    }
}
