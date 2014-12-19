<?php

use Muffin\Conditions;
use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;

class NullConditionTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testBareNullCondition()
    {
        $condition = new Conditions\NullCondition();

        $this->assertSame('', $condition->toString($this->escaper));
    }

    public function testNullConditionAndNullCondition()
    {
        $condition = (new Conditions\NullCondition())->and(new Conditions\NullCondition());

        $this->assertSame('', $condition->toString($this->escaper));
    }

    public function testNullConditionAndCondition()
    {
        $condition = (new Conditions\NullCondition())->and(new Conditions\Different(new Types\Integer('poney'), 666));

        $this->assertSame('poney != 666', $condition->toString($this->escaper));

        $condition = (new Conditions\Different(new Types\Integer('poney'), 666))->and(new Conditions\NullCondition());

        $this->assertSame('poney != 666', $condition->toString($this->escaper));
    }

    public function testNullConditionOrCondition()
    {
        $condition = (new Conditions\NullCondition())->or(new Conditions\Different(new Types\Integer('poney'), 666));

        $this->assertSame('poney != 666', $condition->toString($this->escaper));

        $condition = (new Conditions\Different(new Types\Integer('poney'), 666))->or(new Conditions\NullCondition());

        $this->assertSame('poney != 666', $condition->toString($this->escaper));
    }

    public function testNullConditionAndComposite()
    {
        $composite = (new Conditions\Different(new Types\Integer('poney'), 666))
                        ->and(
                            (new Conditions\Equal(new Types\Integer('response'), 42))
                                ->or(new Conditions\Greater(new Types\Integer('score'), 1337))
                        );

        $condition = (new Conditions\NullCondition())->and($composite);

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));

        $condition = $composite->and(new Conditions\NullCondition());

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));
    }

    public function testNullConditionOrComposite()
    {
        $composite = (new Conditions\Different(new Types\Integer('poney'), 666))
                        ->and(
                            (new Conditions\Equal(new Types\Integer('response'), 42))
                                ->or(new Conditions\Greater(new Types\Integer('score'), 1337))
                        );

        $condition = (new Conditions\NullCondition())->or($composite);

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));

        $condition = $composite->or(new Conditions\NullCondition());

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));
    }

    public function testConditionIsEmpty()
    {
        $condition = new Conditions\NullCondition();

        $this->assertTrue($condition->isEmpty());

        $condition = (new Conditions\NullCondition())->and(new Conditions\Equal(new Types\Integer('response'), 42));

        $this->assertFalse($condition->isEmpty());

        $condition = (new Conditions\Equal(new Types\Integer('response'), 42))->and(new Conditions\NullCondition());

        $this->assertFalse($condition->isEmpty());
    }
}