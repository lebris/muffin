<?php

use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Conditions\Different;

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
        $condition = (new Conditions\NullCondition())->and(new Conditions\Different('poney', new Types\Integer(666)));

        $this->assertSame('poney != 666', $condition->toString($this->escaper));

        $condition = (new Conditions\Different('poney', new Types\Integer(666)))->and(new Conditions\NullCondition());

        $this->assertSame('poney != 666', $condition->toString($this->escaper));
    }

    public function testNullConditionOrCondition()
    {
        $condition = (new Conditions\NullCondition())->or(new Conditions\Different('poney', new Types\Integer(666)));

        $this->assertSame('poney != 666', $condition->toString($this->escaper));

        $condition = (new Conditions\Different('poney', new Types\Integer(666)))->or(new Conditions\NullCondition());

        $this->assertSame('poney != 666', $condition->toString($this->escaper));
    }

    public function testNullConditionAndComposite()
    {
        $composite = (new Conditions\Different('poney', new Types\Integer(666)))
                        ->and(
                            (new Conditions\Equal('response', new Types\Integer(42)))
                                ->or(new Conditions\Greater('score', new Types\Integer(1337)))
                        );

        $condition = (new Conditions\NullCondition())->and($composite);

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));

        $condition = $composite->and(new Conditions\NullCondition());

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));
    }

    public function testNullConditionOrComposite()
    {
        $composite = (new Conditions\Different('poney', new Types\Integer(666)))
                        ->and(
                            (new Conditions\Equal('response', new Types\Integer(42)))
                                ->or(new Conditions\Greater('score', new Types\Integer(1337)))
                        );

        $condition = (new Conditions\NullCondition())->or($composite);

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));

        $condition = $composite->or(new Conditions\NullCondition());

        $this->assertSame('poney != 666 AND (response = 42 OR score > 1337)', $condition->toString($this->escaper));
    }
}