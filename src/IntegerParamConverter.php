<?php

namespace ParamConverter;

use Cake\Core\App;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Class EntityParamConverter
 *
 * Param Converter for Entity classes
 *
 * @package ParamConverter
 */
class IntegerParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === 'int';
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class, $default = null)
    {
        if (ctype_digit($value)) {
            return (int) $value;
        } elseif ($value === '' && is_int($default)) {
            return $default;
        }
        throw new BadRequestException();
    }
}
