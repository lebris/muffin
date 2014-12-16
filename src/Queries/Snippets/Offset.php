<?php

namespace Mdd\QueryBuilder\Queries\Snippets;

use Mdd\QueryBuilder\Snippet;

class Offset implements Snippet
{
    private
        $offset;

    public function __construct($offset)
    {
        $this->offset = $this->ensureIsInteger($offset);
    }

    public function toString()
    {
        if(empty($this->offset))
        {
            return '';
        }

        return sprintf(
            'OFFSET %s',
            $this->offset
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
