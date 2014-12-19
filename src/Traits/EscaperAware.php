<?php

namespace Muffin\Traits;

use Muffin\Escaper;

trait EscaperAware
{
    protected
        $escaper;

    public function setEscaper(Escaper $escaper)
    {
        $this->escaper = $escaper;

        return $this;
    }
}
