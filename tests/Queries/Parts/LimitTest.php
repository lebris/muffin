<?php

use Mdd\QueryBuilder\Queries\Snippets;

class LimitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestLimit
     */
    public function testLimit($expected, $limit, $offset)
    {
        $qb = new Snippets\Limit($limit, $offset);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestLimit()
    {
        return array(
            'null limit' => array('', null, null),
            'empty limit' => array('', '', null),
            'limit string' => array('', 'poney', null),
            'empty limit with offset' => array('', null, 1337),

            'simple limit' => array('LIMIT 42', 42, null),
            'simple limit, int limit as string' => array('LIMIT 42', '42', null),
            'simple limit, float limit' => array('', '42.12', null),
            'simple limit with offset' => array('LIMIT 1337, 42', 42, 1337),
        );
    }
}