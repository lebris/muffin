<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class IsNullTest extends PHPUnit_Framework_TestCase
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
    public function testEqual($expected, $column)
    {
        $condition = new Conditions\IsNull($column);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestEqual()
    {
        return array(
            'nominal' => array('name IS NULL', 'name'),
            'type' => array('name IS NULL', new Types\String('name')),
            'empty column name' => array('', ''),
            'null column name' => array('', null),
        );
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty($expected, $column)
    {
        $condition = new Conditions\IsNull($column);

        $this->assertSame($expected, $condition->isEmpty());
    }

    public function providerTestIsEmpty()
    {
        return array(
            'string column name' => array(false, 'burger'),
            'type column name' => array(false, new Types\String('ponyz')),
            'empty column name' => array(true, ''),
            'null column name' => array(true, null),
        );
    }
}