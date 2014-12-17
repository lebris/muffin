<?php

namespace Mdd\QueryBuilder;

interface Type
{
    public function format($value);

    public function isEscapeRequired();
}
