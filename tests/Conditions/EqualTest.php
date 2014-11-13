<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class EqualTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestEqual
     */
    public function testEqual($expected, $column, Type $type)
    {
        $type->setEscaper($this->escaper);
        $condition = new Conditions\Equal($column, $type);

        $this->assertSame($expected, $condition->toString());
    }

    public function providerTestEqual()
    {
        return array(
            'simple string' => array("name = 'poney'", 'name', new Types\String('poney')),
            'simple int'    => array("id = 666", 'id', new Types\Int(666)),
        );
    }
}