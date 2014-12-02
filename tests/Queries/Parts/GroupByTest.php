<?php

use Mdd\QueryBuilder\Queries\Parts;

class GroupByTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestGroupBy
     */
    public function testGroupBy($expected, array $groupBy)
    {
        $qb = new Parts\GroupBy();

        foreach($groupBy as $column)
        {
            $qb->addGroupBy($column);
        }

        $this->assertSame($expected, $qb->toString());
    }

    public function providerTestGroupBy()
    {
        return array(
            'single column' => array('GROUP BY burger', ['burger']),
            'single column, empty column name' => array('', ['']),
            'single column, null column name' => array('', [null]),

            'multiple column' => array('GROUP BY burger, poney, id', ['burger', 'poney', 'id']),
            'multiple column, empty column name' => array('GROUP BY burger, id', ['burger', '', 'id']),
            'multiple column, null column name' => array('GROUP BY burger, id', ['burger', null, 'id']),
        );
    }
}