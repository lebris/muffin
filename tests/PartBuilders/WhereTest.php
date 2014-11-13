<?php

use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\PartBuilders;

class WhereTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestWhere
     */
    public function testWhere($expected, $condition)
    {
        $where = new PartBuilders\Where($condition);

        $this->assertSame($expected, $where->toString());
    }

    public function providerTestWhere()
    {
        return array(
            '' => array("WHERE name = 'burger'", new Conditions\Equal('', new Types\String('burger'))),
        );
    }
}