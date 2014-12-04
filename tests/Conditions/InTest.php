<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Types\Datetime;

class InTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestIn
     */
    public function testIn($expected, $column, array $type)
    {
        $condition = new Conditions\In($column, $type);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestIn()
    {
        return array(
            'single int' => array("score IN (42)", 'score', [new Types\Integer(42)]),
            'array of int' => array("score IN (42, 1337, 69)", 'score', [new Types\Integer(42), new Types\Integer(1337), new Types\Integer(69)]),

            'single string' => array("race IN ('pony')", 'race', [new Types\String('pony')]),
            'array of string' => array("score IN ('pony', 'unicorn', 'burger')", 'score', [new Types\String('pony'), new Types\String('unicorn'), new Types\String('burger')]),

            'single datetime' => array("race IN ('2014-12-04 20:57:12')", 'race', [new Types\Datetime('2014-12-04 20:57:12')]),
            'array of datetime' => array(
                "race IN ('2014-12-04 20:57:12', '1970-01-01 00:00:00', '1988-03-07 13:37:42')",
                'race',
                [
                    new Types\Datetime('2014-12-04 20:57:12'),
                    new Types\Datetime('1970-01-01 00:00:00'),
                    new Types\Datetime(\DateTime::createFromFormat('Y-m-d H:i:s', '1988-03-07 13:37:42'))
                ]
            ),

            'mixed types' => array(
                "race IN ('pony', 666, '1988-03-07 13:37:42')",
                'race',
                [
                    new Types\String('pony'),
                    new Types\Integer(666),
                    new Types\Datetime(\DateTime::createFromFormat('Y-m-d H:i:s', '1988-03-07 13:37:42'))
                ]
            ),
        );
    }
}