<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Types\Datetime;

class LowerOrEqualTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestLowerOrEqual
     */
    public function testLowerOrEqual($expected, $column, Type $type)
    {
        $condition = new Conditions\LowerOrEqual($column, $type);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestLowerOrEqual()
    {
        return array(
            'null integer' => array("rank <= 0", 'rank', new Types\Integer(null)),
            'integer zero' => array("rank <= 0", 'rank', new Types\Integer(0)),

            'integer' => array("rank <= 1337", 'rank', new Types\Integer(1337)),
            'integer in string' => array("rank <= 42", 'rank', new Types\Integer('42')),

            'empty string' => array("score <= ''", 'score', new Types\String('')),
            'integer as string' => array("score <= '666'", 'score', new Types\String('666')),
            'string' => array("score <= 'unicorn'", 'score', new Types\String('unicorn')),

            'simple datetime' => array("date <= '2014-03-07 14:18:42'", 'date', new Types\Datetime('2014-03-07 14:18:42')),
            'empty datetime' => array("date <= ''", 'date', new Types\Datetime('')),

            'float'    => array("rank <= 13.37", 'rank', new Types\Float(13.37)),

            'empty column name' => array('', '', new Types\String('poney')),
        );
    }
}
