<?php

use Muffin\Type;
use Muffin\Types;
use Muffin\Conditions;
use Muffin\Tests\Escapers\SimpleEscaper;

class IsNotNullTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestIsNotNull
     */
    public function testIsNotNull($expected, $column)
    {
        $condition = new Conditions\IsNotNull($column);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestIsNotNull()
    {
        return array(
            'nominal' => array('name IS NOT NULL', 'name'),
            'type' => array('name IS NOT NULL', new Types\String('name')),
            'empty column name' => array('', ''),
            'null column name' => array('', null),
        );
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty($expected, $column)
    {
        $condition = new Conditions\IsNotNull($column);

        $this->assertSame($expected, $condition->isEmpty());
    }

    public function providerTestIsEmpty()
    {
        return array(
            'string column name' => array(false, 'burger'),
            'type column name'   => array(false, new Types\String('ponyz')),
            'empty column name'  => array(true, ''),
            'null column name'   => array(true, null),
        );
    }
}
