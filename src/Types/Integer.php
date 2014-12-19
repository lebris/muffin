<?php

namespace Muffin\Types;

class Integer extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    public function format($value)
    {
        return (int) $value;
    }
}
