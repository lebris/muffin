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
    public function testDifferent($expected, Type $column, $value)
    {
        $condition = new Conditions\Different($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestDifferent()
    {
        return array(
            'simple string' => array("name != 'poney'", new Types\String('name'), 'poney'),
            'empty string' => array("name != ''", new Types\String('name'), ''),

            'simple int' => array("id != 42", new Types\Integer('id'), 42),
            'empty int' => array("id != 0", new Types\Integer('id'), ''),

            'simple datetime' => array("date != '2014-12-01 13:37:42'", new Types\Datetime('date'), '2014-12-01 13:37:42'),
            'empty datetime' => array("date != ''", new Types\Datetime('date'), ''),

            'empty column name' => array('', new Types\Integer(''), 42),
        );
    }

    /**
     * @dataProvider providerTestDifferentsField
     */
    public function testDifferentsField($expected, $columnLeft, $columnRight)
    {
        $condition = new Conditions\Different($columnLeft, $columnRight);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestDifferentsField()
    {
        return array(
            array('pony != unicorn', new Types\String('pony'), new Types\String('unicorn'),),
            array('pony != id', new Types\String('pony'), new Types\Integer('id'),),
            array('id != pony', new Types\Integer('id'), new Types\String('pony'),),
            array('id != ponyId', new Types\Integer('id'), new Types\Integer('ponyId'),),
            array('creationDate != updateDate', new Types\Datetime('creationDate'), new Types\Datetime('updateDate'),),
            array('good != evil', new Types\Boolean('good'), new Types\Boolean('evil'),),
        );
    }
}