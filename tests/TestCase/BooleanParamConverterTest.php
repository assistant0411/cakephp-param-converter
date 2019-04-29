<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\BooleanParamConverter;

class BooleanParamConverterTest extends TestCase
{
    public function testSupports(): void
    {
        $converter = new BooleanParamConverter();
        $this->assertTrue($converter->supports('bool'));
        $this->assertFalse($converter->supports('int'));
    }

    /**
     * @dataProvider conversionDataProvider
     * @param string $rawValue Raw value
     * @param string $expectedValue Expected value upon conversion
     */
    public function testConvertTo(string $rawValue, string $expectedValue): void
    {
        $converter = new BooleanParamConverter();
        $convertedValue = $converter->convertTo($rawValue, "bool");
        $this->assertEquals($expectedValue, $convertedValue);
        $this->assertInternalType("bool", $convertedValue);
    }

    public function testException(): void
    {
        $converter = new BooleanParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("not-a-bool", "bool");
    }

    /**
     * @return array[]
     */
    public function conversionDataProvider(): array
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
