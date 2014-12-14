<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\PartBuilder;
use Mdd\QueryBuilder\Queries\Parts\TableName;

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
            $this->insertPart = new Parts\Insert($table);
        }
    }

    public function toString()
    {
        $queryParts = array(
            $this->insertPart->toString(),
            $this->buildValuesString(),
        );

        return implode(' ', $queryParts);
    }

    public function insert($table)
    {
        $this->insertPart = new Parts\Insert($table);

        return $this;
    }

    public function values(array $values)
    {
        $this->valuesPart->values($values);

        return $this;
    }

    private function buildValuesString()
    {
        $this->valuesPart->setEscaper($this->escaper);

        return $this->valuesPart->toString();
    }
}
