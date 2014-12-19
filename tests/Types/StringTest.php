<?php

use Muffin\Types;

class StringTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestFormatString
     */
    public function testFormatString($expected, $value)
    {
        $type = new Types\String('column_name');

        $this->assertSame($expected, $type->format($value));
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