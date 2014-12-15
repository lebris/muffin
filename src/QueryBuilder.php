<?php

namespace Mdd\QueryBuilder;

class QueryBuilder
{
    use Traits\EscaperAware;

    public function delete($table = null, $alias = null)
    {
        return (new Queries\Delete($table, $alias))->setEscaper($this->escaper);
    }

    public function insert($table = null)
    {
        return (new Queries\Insert($table))->setEscaper($this->escaper);;
    }

    public function select($columns = null)
    {
        return (new Queries\Select($columns))->setEscaper($this->escaper);;
    }

    public function update($table = null, $alias = null)
    {
        return (new Queries\Update($table, $alias))->setEscaper($this->escaper);;
    }
}
