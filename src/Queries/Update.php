<?php

namespace Mdd\QueryBuilder\Queries;

use Mdd\QueryBuilder\Query;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Traits\EscaperAware;
use Mdd\QueryBuilder\Snippet;
use Mdd\QueryBuilder\Queries\Snippets\Builders;

class Update implements Query
{
    use
        EscaperAware,
        Builders\Join;

    private
        $updatePart,
        $sets,
        $where;

    public function __construct($table = null, $alias = null)
    {
        $this->updatePart = new Snippets\Update();
        $this->where = new Snippets\Where();
        $this->sets = new Snippets\Set();

        if(! empty($table))
        {
            $this->update($table, $alias);
        }
    }

    public function toString()
    {
        $queryParts = array(
            $this->buildUpdate(),
            $this->buildJoin(),
            $this->buildSets(),
            $this->buildWhere(),
        );

        return implode(' ', array_filter($queryParts));
    }

    public function update($table, $alias = null)
    {
        $this->updatePart->addTable($table, $alias);

        return $this;
    }

    public function set(array $fields)
    {
        $this->sets->set($fields);

        return $this;
    }

    public function where(Condition $condition)
    {
        $this->where->where($condition);

        return $this;
    }

    private function buildUpdate()
    {
        $updateString = $this->updatePart->toString();

        if(empty($updateString))
        {
            throw new \RuntimeException('No table defined');
        }

        return $updateString;
    }

    private function buildSets()
    {
        if(!$this->sets instanceof Snippet)
        {
            throw new \LogicException('No column for FROM clause');
        }

        $this->sets->setEscaper($this->escaper);

        return $this->sets->toString();
    }

    private function buildWhere()
    {
        $this->where->setEscaper($this->escaper);

        return $this->where->toString();
    }
}
