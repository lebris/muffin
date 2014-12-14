<?php

use Mdd\QueryBuilder\Queries\Parts;

class InsertPartTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestInsert
     */
    public function testInsert($expected, $tableName)
    {
        $qb = new Parts\Insert($tableName);

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestInsert()
    {
        return array(
            'String table name' => array('INSERT INTO poney', 'poney'),
            'Mixed table name'  => array('INSERT INTO poney666', 'poney666'),
            'wrapped with 0'    => array('INSERT INTO 000poney000', '000poney000'),
        );
    }

    public function testInsertUsingTableNamePart()
    {
        $tableName = new Parts\TableName('unicorns');

        $qb = new Parts\Insert($tableName);

        $this->assertSame($qb->toString(), 'INSERT INTO unicorns');
    }

    /**
     * @dataProvider providerTestEmptyTableName
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyTableName($tableName)
    {
        $qb = new Parts\Insert($tableName);

        $qb->toString($tableName);
    }

    public function providerTestEmptyTableName()
    {
        return array(
            'empty table name' => array(''),
            'null table name' => array(null),
        );
    }
}