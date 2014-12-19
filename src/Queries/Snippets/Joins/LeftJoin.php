<?php

namespace Muffin\Queries\Snippets\Joins;

use Muffin\Snippet;

class LeftJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'LEFT JOIN';
    }
}
