<?php

use Muffin\QueryBuilder;
use Muffin\Queries;
use Muffin\Conditions;
use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;
use Muffin\Queries\Snippets\Distinct;

class QueryBuilderTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testDelete()
    {
        $qb = (new QueryBuilder())->setEscaper($this->escaper);

        $condition = new Conditions\Different(new TYpes\String('taste'), 'burger');

        $query = $qb->delete('poney')->where($condition);

        $delete = new Queries\Delete('poney');
        $delete->setEscaper($this->escaper);
        $delete->where($condition);

        $this->assertSame($delete->toString(), $query->toString());
    }

    public function testInsert()
    {
        $qb = (new QueryBuilder())->setEscaper($this->escaper);

        $values = array(
            'id' => 42,
            'name' => 'julian',
            'taste' => 'burger',
        );

        $query = $qb->insert('poney')->values($values);

        $insert = new Queries\Insert('poney');
        $insert->setEscaper($this->escaper);
        $insert->values($values);

        $this->assertSame($insert->toString(), $query->toString());
    }

    public function testUpdate()
    {
        $qb = (new QueryBuilder())->setEscaper($this->escaper);

        $fields = array('taste' => 'burger');

        $query = $qb->update('poney')->set($fields);

        $update = new Queries\Update('poney');
        $update->setEscaper($this->escaper);
        $update->set($fields);

        $this->assertSame($update->toString(), $query->toString());
    }

    public function testSelect()
    {
        $qb = (new QueryBuilder())->setEscaper($this->escaper);

        $query = $qb
            ->select(array(
                $qb->count($qb->distinct('id'), 'total'),
                'b.type'
            ))
            ->from('burger', 'b');

        $select = new Queries\Select(array(
            new Queries\Snippets\Count(new Queries\Snippets\Distinct('id'), 'total'),
            'b.type',
        ));
        $select->setEscaper($this->escaper);
        $select->from('burger', 'b');

        $this->assertSame($select->toString(), $query->toString());
    }
}
