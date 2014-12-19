<?php

use Muffin\Queries\Snippets;

class UpdateSnippetTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestUpdate
     */
    public function testUpdate($expected, $tableName, $alias)
    {
        $qb = new Snippets\Update($tableName, $alias);

        $this->assertSame($qb->toString(), $expected);
    }

    public function providerTestUpdate()
    {
        return array(
            'String table name' => array('UPDATE burger', 'burger', null),
            'Mixed table name'  => array('UPDATE burger666', 'burger666', null),
            'wrapped with 0'    => array('UPDATE 000burger000', '000burger000', null),
            'empty alias'       => array('UPDATE burger', 'burger', ''),
            'with alias'        => array('UPDATE burger AS b', 'burger', 'b'),
        );
    }

    public function testUpdateUsingTableNamePart()
    {
        $tableName = new Snippets\TableName('ponyz', 'p');

        $qb = new Snippets\Update($tableName);

        $this->assertSame($qb->toString(), 'UPDATE ponyz AS p');
    }

    public function testUpdateAddTable()
    {
        $qb = new Snippets\Update('ponyz', 'p');

        $qb
            ->addTable('burger', 'b')
            ->addTable('unicorn', 'u')
        ;

        $this->assertSame($qb->toString(), 'UPDATE ponyz AS p, burger AS b, unicorn AS u');
    }

    /**
     * @dataProvider providerTestEmptyTableName
     * @expectedException \InvalidArgumentException
     */
    public function testEmptyTableNameUsingSetter($expected, $tableName)
    {
        $qb = new Snippets\Update();

        $qb->addTable($tableName);

        $qb->toString();
    }

    /**
     * @dataProvider providerTestEmptyTableName
     */
    public function testEmptyTableNameUsingConstructor($expected, $tableName)
    {
        $qb = new Snippets\Update($tableName);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestEmptyTableName()
    {
        return array(
            'empty table name' => array('', ''),
            'null table name' => array('', null),
        );
    }
}