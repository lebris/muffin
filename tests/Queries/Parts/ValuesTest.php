<?php

use Mdd\QueryBuilder\Queries\Parts;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class ValuesTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestValues
     */
    public function testValues($expected, array $values)
    {
        $part = new Parts\Values($values);

        $part->setEscaper($this->escaper);

        $this->assertSame($expected, $part->toString());
    }

    public function providerTestValues()
    {
        return array(
            'Nominal'             => array("(id, name) VALUES (42, 'poney')", array('id' => 42, 'name' => 'poney')),
            'empty value'         => array("(id, name) VALUES (42, '')", array('id' => 42, 'name' => '')),
            'null empty value'    => array("(id, name) VALUES (42, NULL)", array('id' => 42, 'name' => null)),
            'value integer as string' => array("(id) VALUES ('42')", array('id' => '42')),
            'value float'         => array("(id, name, score) VALUES (42, 'poney', 13.37)", array('id' => 42, 'name' => 'poney', 'score' => 13.37)),
            'value datetime'      => array("(id, name, date) VALUES (42, 'poney', '2014-03-07 13:37:42')", array('id' => 42, 'name' => 'poney', 'date' => \Datetime::createFromFormat('Y-m-d H:i:s', '2014-03-07 13:37:42'))),
        );
    }

    public function testValuesMultipleSet()
    {
        $part = new Parts\Values();

        $part
            ->values(array(
                'id' => 666,
                'taste' => 'poney',
            ))
            ->values(array(
                'id' => 667,
                'taste' => 'beef'
            ))
        ;

        $part->setEscaper($this->escaper);

        $this->assertSame("(id, taste) VALUES (666, 'poney'), (667, 'beef')", $part->toString());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testValuesMultipleSetDifferentColumns()
    {
        $part = new Parts\Values();

        $part
            ->values(array(
                'id' => 666,
                'taste' => 'poney',
            ))
            ->values(array(
                'name' => 'machin',
                'gender' => 'both'
            ))
        ;

        $part->setEscaper($this->escaper);

        $this->assertSame("(id, taste) VALUES (666, 'poney'), (667, 'beef')", $part->toString());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNoValues()
    {
        $part = new Parts\Values(array());

        $part->setEscaper($this->escaper);

        $part->toString();
    }
}