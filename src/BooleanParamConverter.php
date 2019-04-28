<?php

namespace ParamConverter;

use Cake\Core\App;
use Cake\Http\Exception\BadRequestException;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Class BooleanParamConverter
 *
 * Param Converter for converting boolean like request strings to bool Controller parameters
 *
 * @package ParamConverter
 */
class BooleanParamConverter implements ParamConverterInterface
{
    /**
     * @inheritDoc
     */
    public function supports(string $class): bool
    {
        return $class === 'bool';
    }

    /**
     * @inheritDoc
     */
    public function convertTo(string $value, string $class)
    {
        if (in_array(strtolower($value), ['1', 'true', 'yes', 'on'])) {
            return true;
        } elseif (in_array(strtolower($value), ['0', 'false', 'no', 'off'])) {
            return false;
        }
        throw new BadRequestException();
    }
}
