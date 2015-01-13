<?php

use Muffin\Type;
use Muffin\Types;
use Muffin\Conditions;
use Muffin\Tests\Escapers\SimpleEscaper;

class NotLikeTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestNotLike
     */
    public function testNotLike($expected, Type $column, $value)
    {
        $condition = new Conditions\NotLike($column, $value);

        $this->assertSame($expected, $condition->toString($this->escaper));
    }

    public function providerTestNotLike()
    {
        return array(
            'simple string' => array("taste NOT LIKE 'burger'", new Types\String('taste'), 'burger'),
            'empty string'  => array("name NOT LIKE ''", new Types\String('name'), ''),

            'simple string with starting wildcard' => array("name NOT LIKE '%poney'", new Types\String('name'), '%poney'),
            'simple string with ending wildcard' => array("name NOT LIKE 'poney%'", new Types\String('name'), 'poney%'),
            'simple string wrapped with wildcard' => array("name NOT LIKE '%burger%'", new Types\String('name'), '%burger%'),

            'simple int'    => array("id NOT LIKE 1337", new Types\Integer('id'), 1337),
            'empty int'     => array('id NOT LIKE 0', new Types\Integer('id'), ''),

            'empty column name' => array('', new Types\String(''), 'poney'),
            'empty value' => array('', new Types\String(''), 'poney'),
        );
    }
}
