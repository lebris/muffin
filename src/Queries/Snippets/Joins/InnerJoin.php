<?php

namespace Muffin\Queries\Snippets\Joins;

use Muffin\Snippet;

class InnerJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'INNER JOIN';
    }
}
