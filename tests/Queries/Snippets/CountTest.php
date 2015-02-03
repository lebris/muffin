<?php

use Muffin\Queries\Snippets;

class CountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestCount
     */
    public function testCount($expected, $columnName, $alias)
    {
        $qb = new Snippets\Count($columnName, $alias);

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestCount()
    {
        return array(
            array('COUNT(*)', '*', null),
            array('COUNT(*) AS burger', '*', 'burger'),
            array('COUNT(unicorn) AS burger', 'unicorn', 'burger'),
            array('COUNT(z.unicorn) AS burger', 'z.unicorn', 'burger'),
            array('COUNT(DISTINCT unicorn)', new Snippets\Distinct('unicorn'), null),
            array('COUNT(DISTINCT unicorn) AS burger', new Snippets\Distinct('unicorn'), 'burger'),
            array('COUNT(DISTINCT z.unicorn) AS burger', new Snippets\Distinct('z.unicorn'), 'burger'),
        );
    }

    /**
     * @dataProvider providerTestInvalidCount
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCount($columnName)
    {
        $qb = new Snippets\Count($columnName);
    }

    public function providerTestInvalidCount()
    {
        return array(
            array(''),
            array(null),
        );
    }
}
