<?php

namespace Mdd\QueryBuilder;

interface Condition
{
    public function toString(Escaper $escaper);

    public function isEmpty();
}
