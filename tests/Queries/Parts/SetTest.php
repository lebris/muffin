<?php

use Mdd\QueryBuilder\Queries\Parts;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class SetTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    public function testSet()
    {
        $part = new Parts\Set();
        $part->setEscaper($this->escaper);

        $part->set(array('name' => 'burger'));
        $this->assertSame("SET name = 'burger'", $part->toString());

        $part->set(array(
            'rank' => 42,
            'score' => new Types\Integer(1337)
        ));
        $this->assertSame("SET name = 'burger', rank = '42', score = 1337", $part->toString());

        $part->set(array());
        $this->assertSame("SET name = 'burger', rank = '42', score = 1337", $part->toString());
    }
}