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
                ->or(new Conditions\Equal('rank', new Types\Integer(42)))
            );

        $this->assertSame($condition->toString($this->escaper), "name = 'rainbow' AND (taste = 'burger' OR rank = 42)");
    }

    /**
     * @expectedException \LogicException
     */
    public function testTypoInHelperName()
    {
        $condition = new Conditions\Equal('taste', new Types\String('burger'));
        $condition->adn(new Conditions\Equal('taste', new Types\String('vegetable')));
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
        $conditionC = new Conditions\Equal('rank', new Types\Integer('42'));
        $conditionD = new Conditions\Equal('author', new Types\String('julian'));

        $orComposite1  = new Conditions\Binaries\OrCondition($conditionA, $conditionB);
        $orComposite2  = new Conditions\Binaries\OrCondition($conditionC, $conditionD);

        $andComposite1 = new Conditions\Binaries\AndCondition($conditionA, $conditionB);
        $andComposite2 = new Conditions\Binaries\AndCondition($conditionC, $conditionD);

        return array(
            'simple + simple'       => array("name = 'rainbow' AND taste = 'burger'", $conditionA, $conditionB),

            'AndComposite && condition' => array("(name = 'rainbow' AND taste = 'burger') AND rank = 42", $andComposite1, $conditionC),
            'AndComposite || AndComposite' => array("(name = 'rainbow' AND taste = 'burger') AND (rank = 42 AND author = 'julian')", $andComposite1, $andComposite2),

            'OrComposite || condition' => array("(name = 'rainbow' OR taste = 'burger') AND rank = 42", $orComposite1, $conditionC),
            'OrComposite || OrComposite' => array("(name = 'rainbow' OR taste = 'burger') AND (rank = 42 OR author = 'julian')", $orComposite1, $orComposite2),
        );
    }
}