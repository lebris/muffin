<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Types\Datetime;

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
    public function testEqual($expected, Type $column, $value)
    {
        $condition = new Conditions\Equal($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestEqual()
    {
        return array(
            'simple string' => array("name = 'poney'", new Types\String('name'), 'poney'),
            'empty string'  => array("name = ''", new Types\String('name'), ''),

            'simple int'    => array("id = 666", new Types\Integer('id'), 666),
            'empty int'     => array('id = 0', new Types\Integer('id'), ''),

            'simple datetime'    => array("date = '2014-03-07 14:18:42'", new Types\Datetime('date'), '2014-03-07 14:18:42'),
            'empty datetime'     => array("date = ''", new Types\Datetime('date'), ''),

            'float'    => array("rank = 13.37", new Types\Float('rank'), 13.37),

            'empty column name' => array('', new Types\String(''), 'poney'),
        );
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty($expected, Type $column, $value)
    {
        $condition = new Conditions\Equal($column, $value);

        $this->assertSame($expected, $condition->isEmpty());
    }

    public function providerTestIsEmpty()
    {
        return array(
            'simple string' => array(false, new Types\String('name'), 'poney'),
            'empty string' => array(false, new Types\String('name'), ''),

            'simple int' => array(false, new Types\Integer('id'), 42),
            'empty int' => array(false, new Types\Integer('id'), ''),

            'simple datetime' => array(false, new Types\Datetime('date'), '2014-12-01 13:37:42'),
            'empty datetime' => array(false, new Types\Datetime('date'), ''),

            'empty column name' => array(true, new Types\Integer(''), 42),
        );
    }
}