<?php

namespace Muffin\Queries\Snippets;

use Muffin\Snippet;

class Limit implements Snippet
{
    private
        $limit;

    public function __construct($limit)
    {
        $this->limit = $this->ensureIsInteger($limit);
    }

    public function toString()
    {
        if(empty($this->limit))
        {
            return '';
        }

        return sprintf(
            'LIMIT %s',
            $this->limit
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
