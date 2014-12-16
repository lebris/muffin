<?php

use Mdd\QueryBuilder\Queries\Snippets;

class OffsetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestOffset
     */
    public function testOffset($expected, $limit)
    {
        $qb = new Snippets\Offset($limit);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestOffset()
    {
        return array(
            'null offset' => array('', null),
            'empty offset' => array('', ''),
            'string offset' => array('', 'poney'),

            'simple offset' => array('OFFSET 1337', 1337),
            'simple offset, int offset as string' => array('OFFSET 42', '42'),
            'simple offset, float offset' => array('', '42.12'),
        );
    }
}