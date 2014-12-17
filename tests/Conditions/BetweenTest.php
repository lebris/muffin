<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class BetweenTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestBetween
     */
    public function testBetween($expected, Type $column, $start, $end)
    {
        $condition = new Conditions\Between($column, $start, $end);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestBetween()
    {
        return array(
            'simple string' => array("id BETWEEN 'A' AND 'F'", new Types\String('id'), 'A', 'F'),

            'simple int' => array("id BETWEEN 42 AND 666", new Types\Integer('id'), 42, 666),
            'start value empty' => array('', new Types\Integer('id'), null, 666),
            'end value empty' => array('', new Types\Integer('id'), 42, null),

            'string datetime' => array("date BETWEEN '2014-12-01 13:37:42' AND '2014-12-17 14:18:69'", new Types\Datetime('date'), '2014-12-01 13:37:42', '2014-12-17 14:18:69'),
            'datetime' => array(
                "date BETWEEN '2014-12-01 13:37:42' AND '2014-12-17 14:18:09'",
                new Types\Datetime('date'),
                \Datetime::createFromFormat('Y-m-d H:i:s', '2014-12-01 13:37:42'),
                \Datetime::createFromFormat('Y-m-d H:i:s', '2014-12-17 14:18:09')
            ),
        );
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty($expected, Type $column, $start, $end)
    {
        $condition = new Conditions\Between($column, $start, $end);

        $this->assertSame($expected, $condition->isEmpty());
    }

    public function providerTestIsEmpty()
    {
        return array(
            'simple string' => array(false, new Types\String('id'), 'A', 'F'),

            'all empty' => array(true, new Types\Integer('id'), '', ''),
            'start string empty' => array(true, new Types\String('id'), 'A', ''),
            'end string empty' => array(true, new Types\String('id'), '', 'F'),

            'all null' => array(true, new Types\Integer('id'), null, null),
            'start value null' => array(true, new Types\Integer('id'), null, 666),
            'end value null' => array(true, new Types\Integer('id'), 42, null),

            'simple int' => array(false, new Types\Integer('id'), 42, 666),
        );
    }
}
