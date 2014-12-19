<?php

namespace Muffin\Tests\Escapers;

use Muffin\Escaper;

class SimpleEscaper implements Escaper
{
    public function escape($value)
    {
        return sprintf("'%s'", $value);
    }
}