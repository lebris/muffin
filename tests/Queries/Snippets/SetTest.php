<?php

use Mdd\QueryBuilder\Queries\Snippets;
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
        $part = new Snippets\Set();
        $part->setEscaper($this->escaper);

        $part->set(array('name' => 'burger'));
        $this->assertSame("SET name = 'burger'", $part->toString());

        $part->set(array(
            'rank' => '42',
            'score' => 1337
        ));
        $this->assertSame("SET name = 'burger', rank = '42', score = 1337", $part->toString());

        $part->set(array());
        $this->assertSame("SET name = 'burger', rank = '42', score = 1337", $part->toString());

        $part->set(array(
            'flag' => true
        ));
        $this->assertSame("SET name = 'burger', rank = '42', score = 1337, flag = 1", $part->toString());
    }

    public function testEmptySet()
    {
        $part = new Snippets\Set();
        $part->setEscaper($this->escaper);

        $this->assertSame('', $part->toString());
    }
}