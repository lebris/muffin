<?php

use Muffin\Types;
use Muffin\Tests\Escapers\SimpleEscaper;

class DatetimeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestFormatDatetime
     */
    public function testFormatDatetime($expected, $value)
    {
        $type = new Types\Datetime('column_name');

        $this->assertSame($expected, $type->format($value));
    }

    public function providerTestFormatDatetime()
    {
        return array(
            'string' => array('2014-12-10 13:37:42', '2014-12-10 13:37:42'),
            'empty value' => array('', ''),
            'datetime #1' => array('2014-12-10 13:37:42', \DateTime::createFromFormat('Y-m-d H:i:s', '2014-12-10 13:37:42')),
        );
    }
}