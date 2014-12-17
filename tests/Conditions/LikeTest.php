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
    public function testLike($expected, Type $column, $value)
    {
        $condition = new Conditions\Like($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestLike()
    {
        return array(
            'simple string' => array("taste LIKE 'burger'", new Types\String('taste'), 'burger'),
            'empty string'  => array("name LIKE ''", new Types\String('name'), ''),

            'simple string with starting wildcard' => array("name LIKE '%poney'", new Types\String('name'), '%poney'),
            'simple string with ending wildcard' => array("name LIKE 'poney%'", new Types\String('name'), 'poney%'),
            'simple string wrapped with wildcard' => array("name LIKE '%burger%'", new Types\String('name'), '%burger%'),

            'simple int'    => array("id LIKE 1337", new Types\Integer('id'), 1337),
            'empty int'     => array('id LIKE 0', new Types\Integer('id'), ''),

            'empty column name' => array('', new Types\String(''), 'poney'),
            'empty value' => array('', new Types\String(''), 'poney'),
        );
    }
}