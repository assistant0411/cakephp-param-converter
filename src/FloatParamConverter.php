<?php

namespace ParamConverter;

use Cake\Http\Exception\BadRequestException;

/**
 * Class FloatParamConverter
 *
 * Param Converter for converting float like request strings to float Controller parameters
 *
 * @package ParamConverter
 */
class FloatParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === 'float';
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class)
    {
        if (is_numeric($value)) {
            return (float)$value;
        }
        throw new BadRequestException();
    }
}
