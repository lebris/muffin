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

    public function testHelper()
    {
        $condition = (new Conditions\Equal('name', new Types\String('rainbow')))
            ->and(
                (new Conditions\Equal('taste', new Types\String('burger')))
                ->or(new Conditions\Equal('rank', new Types\Int(42)))
            );

        $this->assertSame($condition->toString($this->escaper), "name = 'rainbow' AND (taste = 'burger' OR rank = 42)");
    }

    /**
     * @dataProvider providerTestAndCondition
     */
    public function testAndCondition($expected, $conditionA, $conditionB)
    {
        $condition = new Conditions\Binaries\AndCondition($conditionA, $conditionB);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestAndCondition()
    {
        $conditionA = new Conditions\Equal('name', new Types\String('rainbow'));
        $conditionB = new Conditions\Equal('taste', new Types\String('burger'));
        $conditionC = new Conditions\Equal('rank', new Types\Int('42'));
        $conditionD = new Conditions\Equal('author', new Types\String('julian'));

        $composite1 = new Conditions\Binaries\AndCondition($conditionA, $conditionB);
        $composite2 = new Conditions\Binaries\AndCondition($conditionC, $conditionD);

        return array(
            'simple + simple'       => array("name = 'rainbow' AND taste = 'burger'", $conditionA, $conditionB),
            'composite + condition' => array("(name = 'rainbow' AND taste = 'burger') AND rank = 42", $composite1, $conditionC),
            'composite + composite' => array("(name = 'rainbow' AND taste = 'burger') AND (rank = 42 AND author = 'julian')", $composite1, $composite2),
        );
    }
}