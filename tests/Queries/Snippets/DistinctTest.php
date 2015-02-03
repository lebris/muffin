<?php

use Muffin\Queries\Snippets;

class DistinctTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestDistinct
     */
    public function testDistinct($expected, $columnName)
    {
        $qb = new Snippets\Distinct($columnName);

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestDistinct()
    {
        return array(
            array('DISTINCT id', 'id'),
        );
    }

    /**
     * @dataProvider providerTestInvalidDistinct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDistinct($columnName)
    {
        $qb = new Snippets\Distinct($columnName);
    }

    public function providerTestInvalidDistinct()
    {
        return array(
            array(''),
            array(null),
        );
    }
}
