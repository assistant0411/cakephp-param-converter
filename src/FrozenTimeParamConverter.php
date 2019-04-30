<?php

namespace ParamConverter;

use Cake\I18n\FrozenTime;

/**
 * Class DateTimeParamConverter
 *
 * Param Converter for FrozenTime class
 *
 * @package ParamConverter
 */
class FrozenTimeParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === FrozenTime::class;
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class)
    {
        return new FrozenTime($value);
    }
}
