<?php

namespace ParamConverter;

use Cake\Core\App;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

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
        if (preg_match('/^-?(?:\d+|\d*\.\d+)$/', $value)) {
            return (float)$value;
        }
        throw new BadRequestException();
    }
}
