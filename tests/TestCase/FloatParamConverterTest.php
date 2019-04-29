<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\FloatParamConverter;

class FloatParamConverterTest extends TestCase
{
    public function testSupports()
    {
        $converter = new FloatParamConverter();
        $this->assertTrue($converter->supports('float'));
        $this->assertFalse($converter->supports('int'));
    }

    /**
     * @dataProvider conversionDateProvider
     */
    public function testConvertTo($rawValue, $expectedValue)
    {
        $converter = new FloatParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "float");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("float", $convertedValue);
    }

    public function testException()
    {
        $converter = new FloatParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("no-float-number", "float");
    }

    public function conversionDateProvider()
    {
        return [
            // raw value, converted value
            ['.1', 0.1],
            ['.1E0', 0.1],
            ['.1E-0', 0.1],
            ['1.1', 1.1],
            ['1', 1.0],
            ['01', 1.0],
        ];
    }
}
