<?php

namespace Mdd\QueryBuilder\Tests\Escapers;

use Mdd\QueryBuilder\Escaper;

class SimpleEscaper implements Escaper
{
    public function escape($value)
    {
        return sprintf("'%s'", $value);
    }
}