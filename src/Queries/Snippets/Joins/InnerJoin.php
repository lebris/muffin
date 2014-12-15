<?php

namespace Mdd\QueryBuilder\Queries\Snippets\Joins;

use Mdd\QueryBuilder\Snippet;

class InnerJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'INNER JOIN';
    }
}
