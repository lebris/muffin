<?php

namespace Muffin\Queries\Snippets\Joins;

use Muffin\Snippet;

class RightJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'RIGHT JOIN';
    }
}
