<?php

use Mdd\QueryBuilder\Queries\Parts;

class OrderByTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultOrderByDirection()
    {
        $qb = new Parts\OrderBy();
        $qb->addOrderBy('poney');

        $this->assertSame('ORDER BY poney ASC', $qb->toString());
    }

    /**
     * @dataProvider providerTestSingleOrderBy
     */
    public function testSingleOrderBy($expected, $column, $direction)
    {
        $qb = new Parts\OrderBy();
        $qb->addOrderBy($column, $direction);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestSingleOrderBy()
    {
        return array(
            'nominal ASC' => array('ORDER BY date ASC', 'date', 'ASC'),
            'nominal DESC' => array('ORDER BY date DESC', 'date', 'DESC'),

            'empty column name' => array('', '', 'DESC'),
            'null column name' => array('', null, 'DESC'),
        );
    }

    /**
     * @dataProvider providerTestMultipleOrderBy
     */
    public function testMultipleOrderBy($expected, array $orderBy)
    {
        $qb = new Parts\OrderBy();

        foreach($orderBy as $column => $direction)
        {
            $qb->addOrderBy($column, $direction);
        }

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestMultipleOrderBy()
    {
        return array(
            'ASC only' => array('ORDER BY date ASC, id ASC', ['date' => 'ASC', 'id' => 'ASC']),
            'DESC only' => array('ORDER BY date DESC, id DESC', ['date' => 'DESC', 'id' => 'DESC']),
            'mixed direction' => array('ORDER BY date DESC, id ASC', ['date' => 'DESC', 'id' => 'ASC']),
            'empty column name' => array('ORDER BY date DESC, id ASC', ['date' => 'DESC', '' => 'ASC', 'id' => 'ASC']),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUnknownOrderByDirection()
    {
        $qb = new Parts\OrderBy();
        $qb->addOrderBy('poney', 'burger');
    }
}