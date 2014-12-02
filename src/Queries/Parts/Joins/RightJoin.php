<?php

namespace Mdd\QueryBuilder\Queries\Parts\Joins;

use Mdd\QueryBuilder\PartBuilder;

class RightJoin extends AbstractJoin implements PartBuilder
{
    protected function getJoinDeclaration()
    {
        return 'RIGHT JOIN';
    }
}