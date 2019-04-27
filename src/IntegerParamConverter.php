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
 * Param Converter for converting integer-like request strings to int Controller parameters
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
    public function convertTo(string $value, string $class)
    {
        if (ctype_digit($value)) {
            return (int)$value;
        }
        throw new BadRequestException();
    }
}
