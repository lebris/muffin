<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class Limit implements Snippet
{
    private
        $limit,
        $offset;

    public function __construct($limit, $offset = null)
    {
        $this->limit = $this->ensureIsInteger($limit);
        $this->offset = $this->ensureIsInteger($offset);
    }

    public function toString()
    {
        if(empty($this->limit))
        {
            return '';
        }

        return sprintf(
            'LIMIT %s',
            implode(', ', array_filter(array($this->offset, $this->limit)))
        );
    }

    private function ensureIsInteger($value)
    {
        if(preg_match('~^[\d]+$~', $value))
        {
            return (int) $value;
        }
    }
}
