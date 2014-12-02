<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class DifferentTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestDifferent
     */
    public function testDifferent($expected, $column, Type $type)
    {
        $condition = new Conditions\Different($column, $type);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestDifferent()
    {
        return array(
            'simple string' => array("name != 'poney'", 'name', new Types\String('poney')),
            'empty string' => array("name != ''", 'name', new Types\String('')),

            'simple int' => array("id != 42", 'id', new Types\Integer(42)),
            'empty int' => array("id != 0", 'id', new Types\Integer('')),

            'empty column name' => array('', '', new Types\Integer(42)),
        );
    }
}