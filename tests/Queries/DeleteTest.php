<?php

use Mdd\QueryBuilder\Queries;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;
use Mdd\QueryBuilder\Queries\Snippets\OrderBy;

class DeleteTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testDeleteSingleTable()
    {
        $query = (new Queries\Delete())->setEscaper($this->escaper);

        $query
            ->from('burger', 'b')
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
        ;

        $this->assertSame("DELETE FROM burger AS b WHERE type = 'healthy'", $query->toString($this->escaper));

        $query->orderBy('date', OrderBy::DESC);

        $this->assertSame("DELETE FROM burger AS b WHERE type = 'healthy' ORDER BY date DESC", $query->toString($this->escaper));

        $query
            ->limit(12)
            ->offset(5)
        ;

        $this->assertSame("DELETE FROM burger AS b WHERE type = 'healthy' ORDER BY date DESC LIMIT 12 OFFSET 5", $query->toString($this->escaper));
    }

    public function testDeleteWithInnerJoin()
    {
        $query = (new Queries\Delete())->setEscaper($this->escaper);

        $query
            ->from('burger', 'b')
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
            ->innerJoin('taste', 't')->on('b.taste_id', 't.id')
        ;

        $this->assertSame("DELETE FROM burger AS b INNER JOIN taste AS t ON b.taste_id = t.id WHERE type = 'healthy'", $query->toString($this->escaper));
    }

    public function testDeleteWithLeftJoin()
    {
        $query = (new Queries\Delete())->setEscaper($this->escaper);

        $query
            ->from('burger', 'b')
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
            ->leftJoin('taste', 't')->on('b.taste_id', 't.id')
        ;

        $this->assertSame("DELETE FROM burger AS b LEFT JOIN taste AS t ON b.taste_id = t.id WHERE type = 'healthy'", $query->toString($this->escaper));
    }

    public function testDeleteWithRightJoin()
    {
        $query = (new Queries\Delete())->setEscaper($this->escaper);

        $query
            ->from('burger', 'b')
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
            ->rightJoin('taste', 't')->on('b.taste_id', 't.id')
        ;

        $this->assertSame("DELETE FROM burger AS b RIGHT JOIN taste AS t ON b.taste_id = t.id WHERE type = 'healthy'", $query->toString($this->escaper));
    }

    public function testDeleteUsingConstructor()
    {
        $query = (new Queries\Delete('burger', 'b'))->setEscaper($this->escaper);

        $query
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
        ;

        $this->assertSame("DELETE FROM burger AS b WHERE type = 'healthy'", $query->toString($this->escaper));
    }
}
