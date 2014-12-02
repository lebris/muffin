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
            'empty column name' => array('', ''),
            'null column name' => array('', null),
        );
    }
}