<?php

use Mdd\QueryBuilder\Queries;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;

class SelectTest extends PHPUnit_Framework_TestCase
{
    public function testSelect()
    {
        $query = new Queries\Select();
        $query
            ->select(array('id', 'name'))
            ->from('poney')
            ->where(new Conditions\Equal('id', new Types\Int(666)))
        ;

        $this->assertSame('SELECT id, name FROM poney WHERE id = 666', $query->toString());
    }
}