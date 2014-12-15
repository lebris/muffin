<?php

namespace Mdd\QueryBuilder\Queries\Parts\Joins;

use Mdd\QueryBuilder\Snippet;

class RightJoin extends AbstractJoin implements Snippet
{
    protected function getJoinDeclaration()
    {
        return 'RIGHT JOIN';
    }
}