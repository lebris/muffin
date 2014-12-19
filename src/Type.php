<?php

namespace Muffin;

interface Type
{
    public function format($value);

    public function isEscapeRequired();
}
