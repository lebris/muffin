<?php

use Muffin\Conditions\Sets\AndSet;
use Muffin\Condition;
use Muffin\Conditions;
use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;

class AndSetTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestToString
     */
    public function testToString(array $conditions, $equivalentCondition)
    {
        $set = new AndSet();

        foreach($conditions as $condition)
        {
            $set->add($condition);
        }

        $this->assertSame($equivalentCondition->toString($this->escaper), $set->toString($this->escaper));
    }

    public function providerTestToString()
    {
        $equal42 = new Conditions\Equal(new Types\Integer('id'), 42);
        $equal51 = new Conditions\Equal(new Types\Integer('id'), 51);
        $burger = new Conditions\Equal(new Types\String('meal'), 'burger');
        $set = (new AndSet)->add($equal42)->add($equal51);
        $emptySet = new AndSet();

        return array(
            'one condition'          => array(array($equal51), $equal51),
            'two conditions'         => array(array($equal51, $equal42), $equal51->and($equal42)),
            'three conditions'       => array(array($equal51, $equal42, $burger), $equal51->and($equal42)->and($burger)),
            'composite'              => array(array($equal42->or($equal51), $burger), ($equal42->or($equal51)->and($burger))),
            'set of set'             => array(array($burger, $set), $burger->and($set)),
            'set of set decomposed'  => array(array($burger, $set), $burger->and($equal42->and($equal51))),
            'empty set'              => array(array($emptySet), new AndSet()),
            'empty set of empty set' => array(array($emptySet->add(new AndSet())->add(new AndSet())), new AndSet()),
            'mixed items'            => array(array($equal42, $emptySet, $burger), $equal42->and($burger)),
        );
    }

    public function testToStringWithEmptySet()
    {
        $set = new AndSet();

        $this->assertTrue($set->isEmpty());
        $this->assertEmpty($set->toString($this->escaper));
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty(Condition $condition = null, $expected)
    {
        $set = new AndSet();

        if($condition instanceof Condition)
        {
            $set->add($condition);
        }

        $this->assertSame($expected, $set->isEmpty());
    }

    public function providerTestIsEmpty()
    {
        return array(
            'empty set' => array(null, true),
            'simple condition' => array(new Conditions\Equal(new Types\Integer('id'), 51), false),
            'composite of empty sets' => array(new Conditions\Binaries\AndCondition(new AndSet(), new AndSet()), true),
            'composite with not empty condition' => array(new Conditions\Binaries\AndCondition(new AndSet(), new Conditions\Equal(new Types\Integer('id'), 51)), false),
            'set of empty set #1' => array(new AndSet(), true),
            'set of empty set #2' => array((new AndSet)->add(new AndSet()), true),
            'set of empty set #3' => array((new AndSet)->add(new AndSet())->add(new AndSet()), true),
            'set of not empty set' => array((new AndSet())->add(new Conditions\Equal(new Types\Integer('id'), 51)), false),
        );
    }
}
