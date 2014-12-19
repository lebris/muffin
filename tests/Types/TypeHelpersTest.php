<?php

use Muffin\Types;
use Muffin\Conditions;
use Muffin\Tests\Escapers\SimpleEscaper;

class TypeHelpersTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testHelper()
    {
        $field = new Types\String('burger');
        $equal = new Conditions\Equal($field, 'poney');
        $different = new Conditions\Different($field, 'poney');
        $like = new Conditions\Like($field, 'poney');
        $greater = new Conditions\Greater($field, 'poney');
        $greaterOrEqual = new Conditions\GreaterOrEqual($field, 'poney');
        $lower = new Conditions\Lower($field, 'poney');
        $lowerOrEqual = new Conditions\LowerOrEqual($field, 'poney');
        $between = new Conditions\Between($field, 42, 666);
        $isNull = new Conditions\IsNull($field);
        $in = new Conditions\In($field, array('poney', 'unicorn'));
        $notIn = new Conditions\NotIn($field, array('poney', 'unicorn'));

        $conditionViaHelper = $field->equal('poney');
        $this->assertEquals($equal->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->different('poney');
        $this->assertEquals($different->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->like('poney');
        $this->assertEquals($like->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->greaterThan('poney');
        $this->assertEquals($greater->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->greaterOrEqualThan('poney');
        $this->assertEquals($greaterOrEqual->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->lowerThan('poney');
        $this->assertEquals($lower->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->lowerOrEqualThan('poney');
        $this->assertEquals($lowerOrEqual->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->between(42, 666);
        $this->assertEquals($between->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->isNull();
        $this->assertEquals($isNull->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->in(array('poney', 'unicorn'));
        $this->assertEquals($in->toString($this->escaper), $conditionViaHelper->toString($this->escaper));

        $conditionViaHelper = $field->notIn(array('poney', 'unicorn'));
        $this->assertEquals($notIn->toString($this->escaper), $conditionViaHelper->toString($this->escaper));
    }
}