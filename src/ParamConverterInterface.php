<?php

namespace ParamConverter;

/**
 * Interface ParamConverterInterface
 *
 * Converts request parameters to objects so that they can be injected to controller actions
 *
 * @package ParamConverter
 */
interface ParamConverterInterface
{
    /**
     * Returns true only and only if the specified class is supported
     *
     * @param string $class Class to be checked
     * @return bool
     */
    public function supports(string $class): bool;

    /**
     * @param string $value Value to be converted
     * @param string $class Target class
     * @return mixed
     */
    public function convertTo(string $value, string $class, $default = null);
}
