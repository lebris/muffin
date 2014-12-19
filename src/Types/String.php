<?php

namespace Muffin\Types;

class String extends AbstractType
{
    public function isEscapeRequired()
    {
        return true;
    }

    public function format($value)
    {
        return (string) $value;
    }
}
