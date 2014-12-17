<?php

use Mdd\QueryBuilder\Queries;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class SelectTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testSelect()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select(array('id', 'name'))
            ->from('poney')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id, name FROM poney WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testSelectAlias()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select(array('id', 'name'))
            ->from('poney', 'z')
        ;

        $this->assertSame("SELECT id, name FROM poney AS z", $query->toString($this->escaper));
    }

    public function testSelectMultipleWhere()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select(array('id', 'name'))
            ->from('poney')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->where(new Conditions\Equal(new Types\Integer('rank'), 42))
        ;

        $this->assertSame("SELECT id, name FROM poney WHERE name = 'burger' AND rank = 42", $query->toString($this->escaper));
    }

    public function testSelectMultipleSelect()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select(array('id', 'name'))
            ->select('rank')
            ->select(array('taste', 'price'))
            ->select('rank')
            ->from('poney')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id, name, rank, taste, price FROM poney WHERE name = 'burger'", $query->toString($this->escaper));
    }

    /**
     * @expectedException \LogicException
     */
    public function testSelectWithoutSelectOrFrom()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query->toString();
    }

    /**
     * @expectedException \LogicException
     */
    public function testSelectWithoutFrom()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper)
            ->select('burger');

        $query->toString();
    }

    /**
     * @expectedException \LogicException
     */
    public function testSelectWithoutSelectingColumns()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);
        $query->from('poney');

        $query->toString();
    }

    /**
     * @expectedException \LogicException
     */
    public function testJoinWrongSynthax()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('truc')
            ->on('p.taste_id', 't.id')
        ;

        $query->toString();
    }

    public function testSingleRightJoin()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->rightJoin('taste', 't')->on('p.taste_id', 't.id')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id FROM poney AS p RIGHT JOIN taste AS t ON p.taste_id = t.id WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testSingleLeftJoin()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->leftJoin('taste', 't')->on('p.taste_id', 't.id')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id FROM poney AS p LEFT JOIN taste AS t ON p.taste_id = t.id WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testSingleInnerJoin()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->innerJoin('taste', 't')->on('p.taste_id', 't.id')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id FROM poney AS p INNER JOIN taste AS t ON p.taste_id = t.id WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testMultipleInnerJoin()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->innerJoin('taste', 't')->on('p.taste_id', 't.id')
            ->innerJoin('country', 'c')->on('c.country_id', 'c.id')
            ->innerJoin('unicorn')->using('code')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id FROM poney AS p INNER JOIN taste AS t ON p.taste_id = t.id INNER JOIN country AS c ON c.country_id = c.id INNER JOIN unicorn USING (code) WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testMultipleMixedJoin()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->innerJoin('taste', 't')->on('p.taste_id', 't.id')
            ->rightJoin('country', 'c')->on('c.country_id', 'c.id')
            ->leftJoin('unicorn')->using('code')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
        ;

        $this->assertSame("SELECT id FROM poney AS p INNER JOIN taste AS t ON p.taste_id = t.id RIGHT JOIN country AS c ON c.country_id = c.id LEFT JOIN unicorn USING (code) WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testLimit()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->limit(42)
        ;

        $this->assertSame("SELECT id FROM poney AS p WHERE name = 'burger' LIMIT 42", $query->toString($this->escaper));
    }

    public function testGroupBy()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->groupBy('taste_id')
            ->groupBy('color')
            ->limit(42)
            ->offset(1337)
            ->orderBy('poney')
        ;

        $this->assertSame("SELECT id FROM poney AS p WHERE name = 'burger' GROUP BY taste_id, color ORDER BY poney ASC LIMIT 42 OFFSET 1337", $query->toString($this->escaper));
    }

    public function testOrderBy()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->limit(42)
            ->offset(1337)
            ->orderBy('poney')
        ;

        $this->assertSame("SELECT id FROM poney AS p WHERE name = 'burger' ORDER BY poney ASC LIMIT 42 OFFSET 1337", $query->toString($this->escaper));
    }

    public function testLimitWithOffset()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->limit(42)
            ->offset(1337)
        ;

        $this->assertSame("SELECT id FROM poney AS p WHERE name = 'burger' LIMIT 42 OFFSET 1337", $query->toString($this->escaper));
    }

    /**
     * @expectedException \LogicException
     */
    public function testOffsetWithoutLimit()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->offset(666)
        ;

        $query->toString($this->escaper);
    }

    public function testOffsetWithEmptyLimit()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->where(new Conditions\Equal(new Types\String('name'), 'burger'))
            ->limit('')
            ->offset(666)
        ;

        $this->assertSame("SELECT id FROM poney AS p WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testHaving()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select('id')
            ->from('poney', 'p')
            ->having(new Conditions\Greater(new Types\Integer('rank'), 42))
        ;

        $this->assertSame("SELECT id FROM poney AS p HAVING rank > 42", $query->toString($this->escaper));

        $query->having(
            (new Conditions\Equal(new Types\Integer('author_id'), 12))->or(new Conditions\Equal(new Types\Integer('author_id'), 666))
        );

        $this->assertSame("SELECT id FROM poney AS p HAVING (rank > 42) AND (author_id = 12 OR author_id = 666)", $query->toString($this->escaper));
    }
}