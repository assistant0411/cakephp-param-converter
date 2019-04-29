<?php

namespace ParamConverter;

use Cake\Http\Exception\BadRequestException;
use DateTime;

/**
 * Class DateTimeParamConverter
 *
 * Param Converter for DateTime class
 *
 * @package ParamConverter
 */
class DateTimeParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === DateTime::class;
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class)
    {
        if (false === strtotime($value)) {
            throw new BadRequestException();
        }

        return new DateTime($value);
    }
}
