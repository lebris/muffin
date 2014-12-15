<?php

namespace Mdd\QueryBuilder;

interface Type
{
    public function getValue();

    public function isEscapeRequired();
}
