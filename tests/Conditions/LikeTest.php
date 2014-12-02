<?php

use Mdd\QueryBuilder\Type;
use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Conditions;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class LikeTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestLike
     */
    public function testLike($expected, $column, Type $type)
    {
        $condition = new Conditions\Like($column, $type);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestLike()
    {
        return array(
            'simple string' => array("taste LIKE 'burger'", 'taste', new Types\String('burger')),
            'empty string'  => array("name LIKE ''", 'name', new Types\String('')),

            'simple string with starting wildcard' => array("name LIKE '%poney'", 'name', new Types\String('%poney')),
            'simple string with ending wildcard' => array("name LIKE 'poney%'", 'name', new Types\String('poney%')),
            'simple string wrapped with wildcard' => array("name LIKE '%burger%'", 'name', new Types\String('%burger%')),

            'simple int'    => array("id LIKE 1337", 'id', new Types\Integer(1337)),
            'empty int'     => array('id LIKE 0', 'id', new Types\Integer('')),

            'empty column name' => array('', '', new Types\String('poney')),
            'empty value' => array('', '', new Types\String('poney')),
        );
    }
}