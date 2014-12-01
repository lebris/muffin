<?php

use Mdd\QueryBuilder\Queries\Parts;

class TableNameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestTableName
     */
    public function testTableName($expected, $tableName, $alias)
    {
        $qb = new Parts\TableName($tableName, $alias);

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestTableName()
    {
        return array(
            'nominal' => array('poney AS p', 'poney', 'p'),
            'alias is table name' => array('poney AS poney', 'poney', 'poney'),
            'empty alias' => array('poney', 'poney', ''),
            'null alias' => array('poney', 'poney', null),
        );
    }

    /**
     * @dataProvider providerTestEmptyTableName
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyTableName($tableName)
    {
        $qb = new Parts\From($tableName);

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