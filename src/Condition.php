<?php

namespace Muffin;

interface Condition
{
    public function toString(Escaper $escaper);

    public function isEmpty();
}
