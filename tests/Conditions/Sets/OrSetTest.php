<?php

use Muffin\Condition;
use Muffin\Conditions;
use Muffin\Types;
use Muffin\Conditions\Sets\OrSet;
use Muffin\Tests\Escapers\SimpleEscaper;

class OrSetTest extends \PHPUnit_Framework_TestCase
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
        $set = new OrSet();

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
        $set = (new OrSet)->add($equal42)->add($equal51);
        $emptySet = new OrSet();

        return array(
            'one condition' => array(array($equal51), $equal51),
            'two conditions' => array(array($equal51, $equal42), $equal51->or($equal42)),
            'three conditions' => array(array($equal51, $equal42, $burger), $equal51->or($equal42)->or($burger)),
            'composite' => array(array($equal42->or($equal51), $burger), ($equal42->or($equal51)->or($burger))),
            'set of set' => array(array($burger, $set), $burger->or($set)),
            'set of set decomposed' => array(array($burger, $set), $burger->or($equal42->or($equal51))),
            'empty set' => array(array($emptySet), new OrSet()),
            'empty set of empty set' => array(array($emptySet->add(new OrSet())->add(new OrSet())), new OrSet()),
            'mixed items' => array(array($equal42, $emptySet, $burger), $equal42->or($burger)),
        );
    }

    public function testToStringWithEmptySet()
    {
        $set = new OrSet();

        $this->assertTrue($set->isEmpty());
        $this->assertEmpty($set->toString($this->escaper));
    }

    /**
     * @dataProvider providerTestIsEmpty
     */
    public function testIsEmpty(Condition $condition = null, $expected)
    {
        $set = new OrSet();

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
            'composite of empty sets' => array(new Conditions\Binaries\OrCondition(new OrSet(), new OrSet()), true),
            'composite with not empty condition' => array(new Conditions\Binaries\OrCondition(new OrSet(), new Conditions\Equal(new Types\Integer('id'), 51)), false),
            'set of empty set #1' => array(new OrSet(), true),
            'set of empty set #2' => array((new OrSet)->add(new OrSet()), true),
            'set of empty set #3' => array((new OrSet)->add(new OrSet())->add(new OrSet()), true),
            'set of not empty set' => array((new OrSet())->add(new Conditions\Equal(new Types\Integer('id'), 51)), false),
        );
    }
}
