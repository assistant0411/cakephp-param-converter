<?php
namespace ParamConverter;

use Cake\I18n\FrozenDate;

/**
 * Class DateTimeParamConverter
 *
 * Param Converter for FrozenDate class
 *
 * @package ParamConverter
 */
class FrozenDateParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === FrozenDate::class;
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class)
    {
        return new FrozenDate($value);
    }
}
