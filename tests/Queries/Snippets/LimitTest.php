<?php

use Muffin\Queries\Snippets;

class LimitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestLimit
     */
    public function testLimit($expected, $limit)
    {
        $qb = new Snippets\Limit($limit);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestLimit()
    {
        return array(
            'null limit' => array('', null),
            'empty limit' => array('', ''),
            'limit string' => array('', 'poney'),

            'simple limit' => array('LIMIT 1337', 1337),
            'simple limit, int limit as string' => array('LIMIT 42', '42'),
            'simple limit, float limit' => array('', '42.12'),
        );
    }
}