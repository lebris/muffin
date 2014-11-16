<?php

use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class StringTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestFormatString
     */
    public function testFormatString($expected, $value)
    {
        $type = new Types\String($value);

        $this->assertSame($expected, $type->getValue());
    }

    public function providerTestFormatString()
    {
        return array(
            'int'           => array("666", 666),
            'int string #1' => array("666", '666'),
            'int string #2' => array("666", '666'),
            'float string'  => array("1337.42", '1337.42'),
            'string'        => array("poney", 'poney'),
        );
    }
}