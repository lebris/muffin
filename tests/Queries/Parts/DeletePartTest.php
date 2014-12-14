<?php

use Mdd\QueryBuilder\Queries\Parts;

class DeletePartTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestDeleteViaConstructor
     */
    public function testDeleteViaConstructor($expected, $columns)
    {
        $select = new Parts\Delete($columns);

        $this->assertSame($expected, $select->toString());
    }

    public function providerTestDeleteViaConstructor()
    {
        return array(
            'single table'     => array('DELETE FROM burger', 'burger'),
        );
    }
}