<?php

use Mdd\QueryBuilder\Queries;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

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
            ->from('burger')
            ->where(new Conditions\Equal('type', new Types\String('healthy')))
        ;

        $this->assertSame("DELETE FROM burger WHERE type = 'healthy'", $query->toString($this->escaper));
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
