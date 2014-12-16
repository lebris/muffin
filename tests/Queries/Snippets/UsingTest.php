<?php

use Mdd\QueryBuilder\Queries\Snippets;

class UsingTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestUsing
     */
    public function testUsing($expected, $columns)
    {
        $part = new Snippets\Using($columns);

        $this->assertSame($expected, $part->toString());
    }

    public function providerTestUsing()
    {
        return array(
            'single columns' => array('USING (id)', 'id'),
            'multiple columns' => array('USING (id, reference)', array('id', 'reference')),
            'null columns' => array('', null),
            'empty columns' => array('', ''),
            'multiple with a null column' => array('USING (id, reference)', array('id', null, 'reference')),
        );
    }
}