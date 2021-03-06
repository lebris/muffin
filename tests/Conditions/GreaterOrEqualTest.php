<?php

use Muffin\Type;
use Muffin\Types;
use Muffin\Conditions;
use Muffin\Tests\Escapers\SimpleEscaper;
use Muffin\Types\Datetime;

class GreaterOrEqualOrEqualTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestGreaterOrEqual
     */
    public function testGreaterOrEqual($expected, Type $column, $value)
    {
        $condition = new Conditions\GreaterOrEqual($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestGreaterOrEqual()
    {
        return array(
            'null integer' => array("rank >= 0", new Types\Integer('rank'), null),
            'integer zero' => array("rank >= 0", new Types\Integer('rank'), 0),

            'integer' => array("rank >= 1337", new Types\Integer('rank'), 1337),
            'integer in string' => array("rank >= 42", new Types\Integer('rank'), '42'),

            'empty string' => array("score >= ''", new Types\String('score'), ''),
            'integer as string' => array("score >= '666'", new Types\String('score'), '666'),
            'string' => array("score >= 'unicorn'", new Types\String('score'), 'unicorn'),

            'simple datetime' => array("date >= '2014-03-07 14:18:42'", new Types\Datetime('date'), '2014-03-07 14:18:42'),
            'empty datetime' => array("date >= ''", new Types\Datetime('date'), ''),

            'float' => array("rank >= 13.37", new Types\Float('rank'), 13.37),

            'empty column name' => array('', new Types\String(''), 'poney'),
        );
    }

    /**
     * @dataProvider providerTestFieldGreaterOrEqualThanField
     */
    public function testFieldGreaterOrEqualThanField($expected, $columnLeft, $columnRight)
    {
        $condition = new Conditions\GreaterOrEqual($columnLeft, $columnRight);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestFieldGreaterOrEqualThanField()
    {
        return array(
            array('pony >= unicorn', new Types\String('pony'), new Types\String('unicorn'),),
            array('pony >= id', new Types\String('pony'), new Types\Integer('id'),),
            array('id >= pony', new Types\Integer('id'), new Types\String('pony'),),
            array('id >= ponyId', new Types\Integer('id'), new Types\Integer('ponyId'),),
            array('creationDate >= updateDate', new Types\Datetime('creationDate'), new Types\Datetime('updateDate'),),
            array('good >= evil', new Types\Boolean('good'), new Types\Boolean('evil'),),
        );
    }
}