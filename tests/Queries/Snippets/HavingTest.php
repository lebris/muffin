<?php

use Muffin\Conditions;
use Muffin\Types;
use Muffin\Queries\Snippets;
use Muffin\Tests\Escapers\SimpleEscaper;

class HavingTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestHaving
     */
    public function testHaving($expected, $condition)
    {
        $qb = new Snippets\Having();
        $qb->setEscaper($this->escaper);
        $qb->having($condition);

        $this->assertSame($expected, $qb->toString($this->escaper));
    }

    public function providerTestHaving()
    {
        $nullCondition = new Conditions\NullCondition();
        $simpleCondition = new Conditions\Greater(new Types\Integer('score'), 42);

        $compositeCondition1 = $simpleCondition->and((new Conditions\Equal(new Types\String('type'), 'burger'))->or(new Conditions\Greater(new Types\Integer('score'), 1337)));
        $compositeCondition2 = $nullCondition->and($simpleCondition)->and((new Conditions\Equal(new Types\String('type'), 'burger'))->or(new Conditions\Greater(new Types\Integer('score'), 1337)));

        $nullAndCompositeCondition = $nullCondition->and((new Conditions\Equal(new Types\String('type'), 'burger'))->or(new Conditions\Greater(new Types\Integer('score'), 1337)));
        $nullCompositeCondition = $nullCondition->and($nullCondition->and($nullCondition->or($nullCondition)));

        return array(
            'null condition' => array('', $nullCondition),
            'null composite condition' => array('', $nullCompositeCondition),

            'simple condition' => array('HAVING score > 42', $simpleCondition),
            'composite condition 1' => array("HAVING score > 42 AND (type = 'burger' OR score > 1337)", $compositeCondition1),
            'nullCondition and simple condition and composite condition 2' => array("HAVING (score > 42) AND (type = 'burger' OR score > 1337)", $compositeCondition2),
        );
    }

    public function testNullHaving()
    {
        $qb = new Snippets\Having();
        $qb->setEscaper($this->escaper);

        $qb->having(new Conditions\NullCondition());

        $this->assertSame('', $qb->toString($this->escaper));
    }
}