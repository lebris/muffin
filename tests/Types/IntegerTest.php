<?php

use Mdd\QueryBuilder\Types;
use Mdd\QueryBuilder\Tests\Escapers\SimpleEscaper;

class IntegerTest extends PHPUnit_Framework_TestCase
{
    protected
        $escaper;

    protected function setUp()
    {
        $this->escaper = new SimpleEscaper();
    }

    /**
     * @dataProvider providerTestFormatInt
     */
    public function testFormatInt($expected, $value)
    {
        $type = new Types\Integer('column_name');

        $this->assertSame($expected, $type->format($value));
    }

    public function providerTestFormatInt()
    {
        return array(
            'int'    => array(666, 666),
            'int string #1' => array(666, '666'),
            'int string #2' => array(666, '0666'),
            'float string' => array(1337, '1337.42'),
            'string' => array(0, 'poney'),
        );
    }
}