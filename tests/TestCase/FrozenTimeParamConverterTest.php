<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\TestCase;
use ParamConverter\FrozenDateTimeParamConverter;

class FrozenTimeParamConverterTest extends TestCase
{
    public function testSupports(): void
    {
        $converter = new FrozenDateTimeParamConverter();
        $this->assertTrue($converter->supports(FrozenTime::class));
    }

    /**
     * @dataProvider conversionDataProvider
     * @param string $rawValue Raw value
     * @param string $expectedValue Expected value upon conversion
     * @param string $format Date format
     */
    public function testConvertTo(string $rawValue, string $expectedValue, string $format): void
    {
        $converter = new FrozenDateTimeParamConverter();
        /** @var \Cake\I18n\FrozenTime $convertedValue */
        $convertedValue = $converter->convertTo($rawValue, FrozenTime::class);
        $this->assertInstanceOf(FrozenTime::class, $convertedValue);
        $this->assertEquals($expectedValue, $convertedValue->format($format));
    }

    public function testException(): void
    {
        $converter = new FrozenDateTimeParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("not-a-valid-datetime", FrozenTime::class);
    }

    /**
     * @return array[]
     */
    public function conversionDataProvider(): array
    {
        return [
            // raw value, converted value
            ['now', date('Y-m-d'), 'Y-m-d'],
            ['now', date('Y-m-d h:i:s'), 'Y-m-d h:i:s'],
            ['2020-09-10', '2020-09-10', 'Y-m-d'],
            ['2020-09-10 15:10:00', '2020-09-10 15:10:00', 'Y-m-d H:i:s'],
        ];
    }
}
