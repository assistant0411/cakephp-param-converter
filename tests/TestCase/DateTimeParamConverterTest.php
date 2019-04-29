<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\DateTimeParamConverter;

class DateTimeParamConverterTest extends TestCase
{
    public function testSupports(): void
    {
        $converter = new DateTimeParamConverter();
        $this->assertTrue($converter->supports(\DateTime::class));
    }

    /**
     * @dataProvider conversionDataProvider
     * @param string $rawValue Raw value
     * @param string $expectedValue Expected value upon conversion
     * @param string $format Date format
     */
    public function testConvertTo(string $rawValue, string $expectedValue, string $format): void
    {
        $converter = new DateTimeParamConverter();
        /** @var \DateTime $convertedValue */
        $convertedValue = $converter->convertTo($rawValue, \DateTime::class);
        $this->assertInstanceOf(\DateTime::class, $convertedValue);
        $this->assertEquals($expectedValue, $convertedValue->format($format));
    }

    public function testException(): void
    {
        $converter = new DateTimeParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("not-a-valid-datetime", \DateTime::class);
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
