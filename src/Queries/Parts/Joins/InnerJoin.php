<?php

namespace Mdd\QueryBuilder\Queries\Parts\Joins;

use Mdd\QueryBuilder\PartBuilder;

class InnerJoin extends AbstractJoin implements PartBuilder
{
    protected function getJoinDeclaration()
    {
        return 'INNER JOIN';
    }
}