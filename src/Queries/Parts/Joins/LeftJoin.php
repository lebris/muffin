<?php

namespace Mdd\QueryBuilder\Queries\Parts\Joins;

use Mdd\QueryBuilder\PartBuilder;

class LeftJoin extends AbstractJoin implements PartBuilder
{
    protected function getJoinDeclaration()
    {
        return 'LEFT JOIN';
    }
}