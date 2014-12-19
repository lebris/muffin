<?php

use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;

class BooleanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestFormatBoolean
     */
    public function testFormatBoolean($expected, $value)
    {
        $type = new Types\Boolean('column_name');

        $this->assertSame($expected, $type->format($value));
    }

    public function providerTestFormatBoolean()
    {
        return array(
            'boolean, false'   => array(0, false),
            'boolean, true'    => array(1, true),

            'integer in string, false'   => array(0, '0'),
            'integer in string, true'    => array(1, '1'),
            'integer, false'   => array(0, 0),
            'integer, true'    => array(1, 1),

            'null'    => array(0, null),
            'empty string'    => array(0, ''),
            'string'    => array(1, 'pony'),
            'string, false'    => array(1, 'false'),
            'string, true'    => array(1, 'true'),
        );
    }
}