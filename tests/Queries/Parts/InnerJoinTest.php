<?php

use Mdd\QueryBuilder\Queries\Parts;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;

class InnerJoinTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestInnerJoinUsing
     */
    public function testInnerJoinUsing($expected, $tableName, $alias, $using)
    {
        $qb = new Parts\InnerJoin($tableName, $alias);
        $qb->using($using);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestInnerJoinUsing()
    {
        return array(
            'Nominal, without alias' => array('INNER JOIN poney USING (id)', 'poney', null, 'id'),
            'Nominal, with alias'    => array('INNER JOIN poney AS p USING (id)', 'poney', 'p', 'id'),
        );
    }

    public function testInnerJoinWithoutCondition()
    {
        $qb = new Parts\InnerJoin('poney', 'p');

        $this->assertSame('INNER JOIN poney AS p', $qb->toString());
    }

    /**
     * @dataProvider providerInnerJoinOn
     */
    public function testInnerJoinOn($expected, $tableName, $alias, $leftColumn, $rightColumn)
    {
        $qb = new Parts\InnerJoin($tableName, $alias);
        $qb->on($leftColumn, $rightColumn);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerInnerJoinOn()
    {
        return array(
            'nominal, without alias' => array('INNER JOIN poney ON p.id = u.reference', 'poney', null, 'p.id', 'u.reference'),
            'nominal, with alias' => array('INNER JOIN poney AS p ON p.id = u.reference', 'poney', 'p', 'p.id', 'u.reference'),
        );
    }

    public function testInnerJoinConditionOverriding()
    {
        $qb = new Parts\InnerJoin('poney','p');
        $qb->on('p.taste', 'b.urger');
        $qb->using('id');

        $this->assertSame('INNER JOIN poney AS p USING (id)', $qb->toString());

        $qb = new Parts\InnerJoin('poney','p');
        $qb->on('p.taste', 'b.urger');
        $qb->using('id')->on('p.unicorn', 'r.rainbow');

        $this->assertSame('INNER JOIN poney AS p ON p.unicorn = r.rainbow', $qb->toString());
    }
}