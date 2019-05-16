<?php
namespace ParamConverter;

use Cake\Chronos\Date;
use Cake\Http\Exception\BadRequestException;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

/**
 * Class FrozenDateTimeParamConverter
 *
 * Param Converter for FrozenDate and FrozenTime classes
 */
class FrozenDateTimeParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === FrozenDate::class || $class === FrozenTime::class || $class === Time::class;
    }

    /**
     * @inheritDoc
     *
     * @param string $value from URL.
     * @param string $class FrozenDate or FrozenTime.
     *
     * @return FrozenTime|FrozenDate
     */
    public function convertTo(string $value, string $class)
    {
        try {
            return new $class($value);
        } catch (\Exception $e) {
            throw new BadRequestException();
        }
    }
}
