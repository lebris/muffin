<?php

use Mdd\QueryBuilder\PartBuilder;

abstract class PartBuilderTestCase extends PHPUnit_Framework_TestCase
{
    protected function assertQueryIs(PartBuilder $qb, $expected)
    {
        $this->assertSame($expected, $qb->toString());
    }
}