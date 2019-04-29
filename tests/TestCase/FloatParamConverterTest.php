<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\FloatParamConverter;

class FloatParamConverterTest extends TestCase
{
    public function testSupports(): void
    {
        $converter = new FloatParamConverter();
        $this->assertTrue($converter->supports('float'));
        $this->assertFalse($converter->supports('int'));
    }

    /**
     * @dataProvider conversionDataProvider
     * @param string $rawValue Raw value
     * @param string $expectedValue Expected value upon conversion
     */
    public function testConvertTo(string $rawValue, string $expectedValue): void
    {
        $converter = new FloatParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "float");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("float", $convertedValue);
    }

    public function testException(): void
    {
        $converter = new FloatParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("no-float-number", "float");
    }

    /**
     * @return array[]
     */
    public function conversionDataProvider(): array
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
