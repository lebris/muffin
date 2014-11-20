<?php

use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class AndConditionTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestAndCondition
     */
    public function testAndCondition($expected, $conditionA, $conditionB)
    {
        $condition = new Conditions\AndCondition($conditionA, $conditionB);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestAndCondition()
    {
        $conditionA = new Conditions\Equal('name', new Types\String('rainbow'));
        $conditionB = new Conditions\Equal('taste', new Types\String('burger'));
        $conditionC = new Conditions\Equal('rank', new Types\Int('42'));

        $nestedConditions = new Conditions\AndCondition($conditionA, $conditionB);

        return array(
            'simple And Condition' => array("(name = 'rainbow' AND taste = 'burger')", $conditionA, $conditionB),
            'nested And Condition' => array("((name = 'rainbow' AND taste = 'burger') AND rank = 42)", $nestedConditions, $conditionC),
        );
    }
}