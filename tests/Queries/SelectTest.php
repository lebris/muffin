<?php

use Mdd\QueryBuilder\Queries;

class SelectTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestSimpleSelect
     */
    public function testSimpleSelect($expected, $columns, $tableName)
    {
        $qb = new Queries\Select($columns);

        $qb
            ->from($tableName)
        ;

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestSimpleSelect()
    {
        $tableName = 'poney';

        return array(
            'single column'      => array('SELECT name FROM poney', 'name', $tableName),
            'multiple column'    => array('SELECT name, color, age FROM poney', array('name', 'color', 'age'), $tableName),
            'duplicated columns' => array('SELECT name, color, age FROM poney', array('name', 'color', 'age', 'name'), $tableName),
            'all columns'        => array('SELECT * FROM poney', '*', $tableName),
        );
    }

//     public function testSelectWithCondition()
//     {
//         $qb = new Queries\Select($columns);

//         $qb
//             ->from($tableName)
//             ->where()
//         ;

//         $this->assertSame($qb->toString(), $expected);
//     }

    public function testAddSelect()
    {
        $qb = new Queries\Select("");

        $qb
            ->from('poney')
            ->select('name')
            ->select('color')
            ->select('age')
        ;

        $this->assertSame($qb->toString(), 'SELECT name, color, age FROM poney');
    }

    public function testAddSameColumnSelection()
    {
        $qb = new Queries\Select("");

        $qb
            ->from('poney')
            ->select('name')
            ->select('color')
            ->select('age')
            ->select('color')
        ;

        $this->assertSame($qb->toString(), 'SELECT name, color, age FROM poney');
    }

    /**
     * @dataProvider providerTestInvalidTableName
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidTableName($tableName)
    {
        $qb = new Queries\Select('*');

        $qb->from($tableName);
    }

    public function providerTestInvalidTableName()
    {
        return array(
            'empty table name' => array(''),
            'non string table name' => array(array()),
        );
    }
}