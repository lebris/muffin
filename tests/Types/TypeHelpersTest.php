<?php

use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class TypeHelpersTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestHelper
     */
    public function testHelper($expected, $conditionViaHelper)
    {
        $this->assertSame($expected->toString($this->escaper), $conditionViaHelper->toString($this->escaper));
    }

    public function providerTestHelper()
    {
        $field = new Types\String('burger');

        return array(
            'Equal' => array(new Conditions\Equal($field, 'poney'), $field->equal('poney')),
            'Different' => array(new Conditions\Different($field, 'poney'), $field->different('poney')),
            'Like' => array(new Conditions\Like($field, 'poney'), $field->like('poney')),

            'Greater' => array(new Conditions\Greater($field, 42), $field->greaterThan(42)),
            'GreaterOrEqual' => array(new Conditions\GreaterOrEqual($field, 42), $field->greaterOrEqualThan(42)),

            'Lower' => array(new Conditions\Lower($field, 42), $field->lowerThan(42)),
            'LowerOrEqual' => array(new Conditions\LowerOrEqual($field, 42), $field->lowerOrEqualThan(42)),

            'Between' => array(new Conditions\Between($field, 42, 666), $field->between(42, 666)),

            'IsNull' => array(new Conditions\IsNull($field), $field->IsNull()),

            'In' => array(new Conditions\In($field, array('poney', 'unicorn')), $field->in(array('poney', 'unicorn'))),
            'NotIn' => array(new Conditions\NotIn($field, array('poney', 'unicorn')), $field->notIn(array('poney', 'unicorn'))),
        );
    }
}