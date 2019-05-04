<?php
namespace ParamConverter;

use Cake\Chronos\Date;
use Cake\Http\Exception\BadRequestException;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;

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
        return $class === FrozenDate::class || $class === FrozenTime::class;
    }

    /**
     * @inheritDoc
     *
     * @param string $value from URL
     * @param string $class FrozenDate or FrozenTime.
     *
     * @return FrozenTime|FrozenDate
     */
    public function convertTo(string $value, string $class)
    {
        try {
            if ($class === FrozenDate::class) {
                return new FrozenDate($value);
            } else {
                return new FrozenTime($value);
            }
        } catch (\Exception $e) {
            throw new BadRequestException();
        }
    }
}
