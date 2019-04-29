<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\IntegerParamConverter;

class IntegerParamConverterTest extends TestCase
{
    public function testSupports()
    {
        $converter = new IntegerParamConverter();
        $this->assertTrue($converter->supports('int'));
        $this->assertFalse($converter->supports('float'));
    }

    /**
     * @dataProvider conversionDateProvider
     */
    public function testConvertTo($rawValue, $expectedValue)
    {
        $converter = new IntegerParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "int");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("int", $convertedValue);
    }

    public function testException()
    {
        $converter = new IntegerParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("no-int-number", "int");
    }

    public function conversionDateProvider()
    {
        return [
            // raw value, converted value
            ['1', 1],
            ['01', 1],
        ];
    }
}
