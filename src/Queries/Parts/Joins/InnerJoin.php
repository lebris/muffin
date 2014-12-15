<?php

namespace Mdd\QueryBuilder\Queries\Parts\Joins;

use Mdd\QueryBuilder\Snippet;

class InnerJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'INNER JOIN';
    }
}