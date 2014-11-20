<?php

use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Condition;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Queries\Parts;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class WhereTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestWhere
     */
    public function testWhere($expected, Condition $condition)
    {
        $where = new Parts\Where($condition);
        $where->setEscaper($this->escaper);

        $this->assertSame($expected, $where->toString());
    }

    public function providerTestWhere()
    {
        return array(
            'empty condition' => array('', new Conditions\Equal('', new Types\String(''))),
            'simple string condition #1' => array("WHERE name = 'burger'", new Conditions\Equal('name', new Types\String('burger'))),
            'simple string condition #2' => array("WHERE name = '666'", new Conditions\Equal('name', new Types\String('666'))),
            'simple int condition' => array("WHERE name = 666", new Conditions\Equal('name', new Types\Int(666))),
        );
    }
}