<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\BooleanParamConverter;

class BooleanParamConverterTest extends TestCase
{
    public function testSupports()
    {
        $converter = new BooleanParamConverter();
        $this->assertTrue($converter->supports('bool'));
        $this->assertFalse($converter->supports('int'));
    }

    /**
     * @dataProvider conversionDateProvider
     */
    public function testConvertTo($rawValue, $expectedValue)
    {
        $converter = new BooleanParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "bool");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("bool", $convertedValue);
    }

    public function testException()
    {
        $converter = new BooleanParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("not-a-bool", "bool");
    }

    public function conversionDateProvider()
    {
        return [
            // raw value, converted value
            ['1', true],
            ['0', false],
            ['true', true],
            ['false', false],
            ['yes', true],
            ['no', false],
            ['on', true],
            ['off', false],
        ];
    }
}
