<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\IntegerParamConverter;

class IntegerParamConverterTest extends TestCase
{
    public function testSupports(): void
    {
        $converter = new IntegerParamConverter();
        $this->assertTrue($converter->supports('int'));
        $this->assertFalse($converter->supports('float'));
    }

    /**
     * @dataProvider conversionDataProvider
     * @param string $rawValue Raw value
     * @param string $expectedValue Expected value upon conversion
     */
    public function testConvertTo(string $rawValue, string $expectedValue): void
    {
        $converter = new IntegerParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "int");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("int", $convertedValue);
    }

    public function testException(): void
    {
        $converter = new IntegerParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("no-int-number", "int");
    }

    /**
     * @return array[]
     */
    public function conversionDataProvider(): array
    {
        return [
            // raw value, converted value
            ['1', 1],
            ['01', 1],
        ];
    }
}
