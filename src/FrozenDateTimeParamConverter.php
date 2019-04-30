<?php
namespace ParamConverter;

use Cake\Chronos\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;

/**
 * Class FrozenDateTimeParamConverter
 *
 * Param Converter for FrozenDate and FrozenTime classes
 *
 * @package ParamConverter
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
     * @param string $class 'FrozenDate' or 'FrozenTime'
     *
     * @return FrozenTime|FrozenDate
     */
    public function convertTo(string $value, string $class)
    {
        if ($class === FrozenDate::class) {
            return new FrozenDate($value);
        } else {
            return new FrozenTime($value);
        }
    }
}
