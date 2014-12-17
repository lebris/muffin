<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Types\Datetime;

class GreaterTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestGreater
     */
    public function testGreater($expected, Type $column, $value)
    {
        $condition = new Conditions\Greater($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestGreater()
    {
        return array(
            'null integer' => array("rank > 0", new Types\Integer('rank'), null),
            'integer zero' => array("rank > 0", new Types\Integer('rank'), 0),

            'integer' => array("rank > 1337", new Types\Integer('rank'), 1337),
            'integer in string' => array("rank > 42", new Types\Integer('rank'), '42'),

            'empty string' => array("score > ''", new Types\String('score'), ''),
            'integer as string' => array("score > '666'", new Types\String('score'), '666'),
            'string' => array("score > 'unicorn'", new Types\String('score'), 'unicorn'),

            'simple datetime' => array("date > '2014-03-07 14:18:42'", new Types\Datetime('date'), '2014-03-07 14:18:42'),
            'empty datetime' => array("date > ''", new Types\Datetime('date'), ''),

            'float' => array("rank > 13.37", new Types\Float('rank'), 13.37),

            'empty column name' => array('', new Types\String(''), 'poney'),
        );
    }
}