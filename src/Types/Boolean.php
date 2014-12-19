<?php

namespace Muffin\Types;

class Boolean extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    public function format($value)
    {
        return (int) ((bool) $value);
    }
}
