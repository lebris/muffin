<?php

namespace Muffin\Types;

class Float extends AbstractType
{
    public function isEscapeRequired()
    {
        return false;
    }

    public function format($value)
    {
        return floatval($value);
    }
}
