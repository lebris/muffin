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
}