<?php
namespace ParamConverter;

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
     * @param string $class 'FrozenDate' or 'FrozenTime'
     */
    public function convertTo(string $value, string $class)
    {
        return new $class($value);
    }
}
