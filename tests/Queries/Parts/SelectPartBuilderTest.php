<?php

use Mdd\QueryBuilder\Queries\Parts;

class SelectPartBuilderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestSelectViaConstructor
     */
    public function testSelectViaConstructor($expected, $columns)
    {
        $select = new Parts\Select($columns);

        $this->assertSame($expected, $select->toString());
    }

    /**
     * @dataProvider providerTestSelectViaConstructor
     */
    public function testSelectViaSetter($expected, $columns)
    {
        $select = new Parts\Select();
        $select->select($columns);

        $this->assertSame($expected, $select->toString());
    }

    public function providerTestSelectViaConstructor()
    {
        return array(
            'single column'      => array('SELECT name', 'name'),
            'multiple column'    => array('SELECT name, color, age', array('name', 'color', 'age')),
            'duplicated columns' => array('SELECT name, color, age', array('name', 'color', 'age', 'name')),
            'all columns'        => array('SELECT *', '*'),
        );
    }

    public function testAddColumnsOnTheFly()
    {
        $select = new Parts\Select('id');
        $select
            ->select('name')
            ->select(array('color', 'taste'));

        $this->assertSame('SELECT id, name, color, taste', $select->toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidColumnName()
    {
        $select = new Parts\Select(array('poney', new stdClass()));

        $select->toString();
    }
}