<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Joins;

use Mdd\QueryBuilder\Snippet;

class LeftJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'LEFT JOIN';
    }
}