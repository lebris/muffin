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
        $condition = new Conditions\Equal($column, $type);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestEqual()
    {
        return array(
            'simple string' => array("name = 'poney'", 'name', new Types\String('poney')),
            'empty string'  => array("name = ''", 'name', new Types\String('')),
            'simple int'    => array("id = 666", 'id', new Types\Int(666)),
            'empty int'     => array('id = 0', 'id', new Types\Int('')),
            'empty column name' => array('', '', new Types\String('poney')),
        );
    }
}