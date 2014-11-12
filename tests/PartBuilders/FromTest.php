<?php

use Mdd\QueryBuilder\PartBuilders;

require 'PartBuilderTestCase.php';

class FromTest extends PartBuilderTestCase
{
    /**
     * @dataProvider providerTestFrom
     */
    public function testFrom($expected, $tableName)
    {
        $qb = new PartBuilders\From($tableName);

        $this->assertQueryIs($qb, $expected);
    }

    public function providerTestFrom()
    {
        return array(
            'String table name' => array('FROM poney', 'poney'),
            'Mixed table name'  => array('FROM poney666', 'poney666'),
            'wrapped with 0'    => array('FROM 000poney000', '000poney000'),
        );
    }

    /**
     * @dataProvider providerTestInvalidTableName
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidTableName($tableName)
    {
        $qb = new PartBuilders\From($tableName);

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