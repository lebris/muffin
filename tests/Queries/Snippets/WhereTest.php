<?php

use Muffin\Types;
use Muffin\Condition;
use Muffin\Conditions;
use Muffin\Queries\Snippets;
use Muffin\Tests\Escapers\SimpleEscaper;

class WhereTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestWhere
     */
    public function testWhere($expected, Condition $condition)
    {
        $where = new Snippets\Where($condition);
        $where->setEscaper($this->escaper);

        $this->assertSame($expected, $where->toString());
    }

    public function providerTestWhere()
    {
        return array(
            'empty condition' => array('', new Conditions\Equal(new Types\String(''), '')),
            'simple string condition #1' => array("WHERE name = 'burger'", new Conditions\Equal(new Types\String('name'), 'burger')),
            'simple string condition #2' => array("WHERE name = '666'", new Conditions\Equal(new Types\String('name'), '666')),
            'simple int condition' => array("WHERE name = 666", new Conditions\Equal(new Types\Integer('name'), 666)),
        );
    }
}