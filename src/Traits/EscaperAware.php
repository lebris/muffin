<?php

namespace Mdd\QueryBuilder\Traits;

use Mdd\QueryBuilder\Escaper;

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