<?php

use Muffin\Conditions;
use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;

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
        $condition = (new Conditions\Equal(new Types\String('name'), 'rainbow'))
            ->or(
                (new Conditions\Equal(new Types\String('taste'), 'burger'))
                ->and(new Conditions\Equal(new Types\Integer('rank'), 42))
            );

        $this->assertSame($condition->toString($this->escaper), "name = 'rainbow' OR (taste = 'burger' AND rank = 42)");
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoParameterGiven()
    {
        $condition = new Conditions\Equal(new Types\String('taste'), 'burger');
        $condition->or();
    }

    /**
     * @expectedException \LogicException
     */
    public function testTypoInOrHelperName()
    {
        $condition = new Conditions\Equal(new Types\String('taste'), 'burger');
        $condition->ro(new Conditions\Equal(new Types\String('taste'), 'vegetable'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testTypoInAndHelperName()
    {
        $condition = new Conditions\Equal(new Types\String('taste'), 'burger');
        $condition->adn(new Conditions\Equal(new Types\String('taste'), 'vegetable'));
    }
}