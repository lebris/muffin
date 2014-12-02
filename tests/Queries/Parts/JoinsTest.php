<?php

use Mdd\QueryBuilder\Queries\Parts;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;

class JoinsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestRightJoinUsing
     */
    public function testRightJoinUsing($expected, $tableName, $alias, $using)
    {
        $qb = new Parts\Joins\RightJoin($tableName, $alias);
        $qb->using($using);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestRightJoinUsing()
    {
        return array(
            'Nominal, without alias' => array('RIGHT JOIN poney USING (id)', 'poney', null, 'id'),
            'Nominal, with alias'    => array('RIGHT JOIN poney AS p USING (id)', 'poney', 'p', 'id'),
        );
    }

    /**
     * @dataProvider providerTestLeftJoinUsing
     */
    public function testLeftJoinUsing($expected, $tableName, $alias, $using)
    {
        $qb = new Parts\Joins\LeftJoin($tableName, $alias);
        $qb->using($using);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestLeftJoinUsing()
    {
        return array(
            'Nominal, without alias' => array('LEFT JOIN poney USING (id)', 'poney', null, 'id'),
            'Nominal, with alias'    => array('LEFT JOIN poney AS p USING (id)', 'poney', 'p', 'id'),
        );
    }

    /**
     * @dataProvider providerTestInnerJoinUsing
     */
    public function testInnerJoinUsing($expected, $tableName, $alias, $using)
    {
        $qb = new Parts\Joins\InnerJoin($tableName, $alias);
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

    public function testJoinWithoutCondition()
    {
        $qb = new Parts\Joins\LeftJoin('poney', 'p');

        $this->assertSame('LEFT JOIN poney AS p', $qb->toString());

        $qb = new Parts\Joins\InnerJoin('poney', 'p');

        $this->assertSame('INNER JOIN poney AS p', $qb->toString());
    }

    /**
     * @dataProvider providerRightJoinOn
     */
    public function testRightJoinOn($expected, $tableName, $alias, $leftColumn, $rightColumn)
    {
        $qb = new Parts\Joins\RightJoin($tableName, $alias);
        $qb->on($leftColumn, $rightColumn);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerRightJoinOn()
    {
        return array(
            'nominal, without alias' => array('RIGHT JOIN poney ON p.id = u.reference', 'poney', null, 'p.id', 'u.reference'),
            'nominal, with alias' => array('RIGHT JOIN poney AS p ON p.id = u.reference', 'poney', 'p', 'p.id', 'u.reference'),
        );
    }

    /**
     * @dataProvider providerLeftJoinOn
     */
    public function testLeftJoinOn($expected, $tableName, $alias, $leftColumn, $rightColumn)
    {
        $qb = new Parts\Joins\LeftJoin($tableName, $alias);
        $qb->on($leftColumn, $rightColumn);

        $this->assertSame($expected, $qb->toString());
    }

    public function providerLeftJoinOn()
    {
        return array(
            'nominal, without alias' => array('LEFT JOIN poney ON p.id = u.reference', 'poney', null, 'p.id', 'u.reference'),
            'nominal, with alias' => array('LEFT JOIN poney AS p ON p.id = u.reference', 'poney', 'p', 'p.id', 'u.reference'),
        );
    }

    /**
     * @dataProvider providerInnerJoinOn
     */
    public function testInnerJoinOn($expected, $tableName, $alias, $leftColumn, $rightColumn)
    {
        $qb = new Parts\Joins\InnerJoin($tableName, $alias);
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

    public function testJoinConditionOverriding()
    {
        $qb = new Parts\Joins\InnerJoin('poney','p');
        $qb->on('p.taste', 'b.urger');
        $qb->using('id');

        $this->assertSame('INNER JOIN poney AS p USING (id)', $qb->toString());

        $qb = new Parts\Joins\InnerJoin('poney','p');
        $qb->on('p.taste', 'b.urger');
        $qb->using('id')->on('p.unicorn', 'r.rainbow');

        $this->assertSame('INNER JOIN poney AS p ON p.unicorn = r.rainbow', $qb->toString());
    }
}