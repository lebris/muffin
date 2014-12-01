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
            ->where(new Conditions\Equal('name', new Types\String('burger')))
        ;

        $this->assertSame("SELECT id, name FROM poney WHERE name = 'burger'", $query->toString($this->escaper));
    }

    public function testSelectMultipleWhere()
    {
        $query = (new Queries\Select())->setEscaper($this->escaper);

        $query
            ->select(array('id', 'name'))
            ->from('poney')
            ->where(new Conditions\Equal('name', new Types\String('burger')))
            ->where(new Conditions\Equal('rank', new Types\Int(42)))
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
            ->where(new Conditions\Equal('name', new Types\String('burger')))
        ;

        $this->assertSame("SELECT id, name, rank, taste, price FROM poney WHERE name = 'burger'", $query->toString($this->escaper));
    }

//     public function testSelectInnerJoin()
//     {
//         $query = (new Queries\Select())->setEscaper($this->escaper);

//         $query
//             ->select('id')
//             ->from('poney', 'p')
//             ->innerJoin('')->on()
//             ->where(new Conditions\Equal('name', new Types\String('burger')))
//         ;

//         $this->assertSame("SELECT id, name, rank, taste, price FROM poney AS p WHERE name = 'burger'", $query->toString($this->escaper));
//     }
}