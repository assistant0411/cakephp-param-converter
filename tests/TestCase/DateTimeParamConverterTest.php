<?php

namespace ParamConverter\Test\TestCase;

use Cake\Http\Exception\BadRequestException;
use Cake\TestSuite\TestCase;
use ParamConverter\DateTimeParamConverter;

class DateTimeParamConverterTest extends TestCase
{
    public function testSupports()
    {
        $converter = new DateTimeParamConverter();
        $this->assertTrue($converter->supports(\DateTime::class));
    }

    /**
     * @dataProvider conversionDataProvider
     */
    public function testConvertTo($rawValue, $expectedValue, $format)
    {
        $converter = new DateTimeParamConverter();
        /** @var \DateTime $convertedValue */
        $convertedValue = $converter->convertTo($rawValue, \DateTime::class);
        $this->assertInstanceOf(\DateTime::class, $convertedValue);
        $this->assertEquals($expectedValue, $convertedValue->format($format));
    }

    public function testException()
    {
        $converter = new DateTimeParamConverter();
        $this->expectException(BadRequestException::class);
        $converter->convertTo("not-a-valid-datetime", \DateTime::class);
    }

    public function conversionDataProvider()
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
