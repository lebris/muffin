<?php

use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class HelperTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testMixedHelper()
    {
        $condition = (new Conditions\Equal('name', new Types\String('rainbow')))
            ->or(
                (new Conditions\Equal('taste', new Types\String('burger')))
                ->and(new Conditions\Equal('rank', new Types\Integer(42)))
            );

        $this->assertSame($condition->toString($this->escaper), "name = 'rainbow' OR (taste = 'burger' AND rank = 42)");
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoParameterGiven()
    {
        $condition = new Conditions\Equal('taste', new Types\String('burger'));
        $condition->or();
    }

    /**
     * @expectedException \LogicException
     */
    public function testTypoInOrHelperName()
    {
        $condition = new Conditions\Equal('taste', new Types\String('burger'));
        $condition->ro(new Conditions\Equal('taste', new Types\String('vegetable')));
    }

    /**
     * @expectedException \LogicException
     */
    public function testTypoInAndHelperName()
    {
        $condition = new Conditions\Equal('taste', new Types\String('burger'));
        $condition->adn(new Conditions\Equal('taste', new Types\String('vegetable')));
    }
}