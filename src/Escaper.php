<?php

namespace Mdd\QueryBuilder;

interface Escaper
{
    public function escape($value);
}