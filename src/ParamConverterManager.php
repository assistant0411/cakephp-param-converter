<?php

namespace ParamConverter;

use Cake\Http\ServerRequest;
use ReflectionMethod;

class ParamConverterManager
{
    /**
     * @var \ParamConverter\ParamConverterInterface[]
     */
    private $converters;

    /**
     * ParamConverterManager constructor.
     * @param \ParamConverter\ParamConverterInterface[] $paramConverters List of converters
     */
    public function __construct(array $paramConverters)
    {
        foreach ($paramConverters as $paramConverter) {
            $this->add($paramConverter);
        }
    }

    /**
     * Add the specified converter
     *
     * @param \ParamConverter\ParamConverterInterface $paramConverter Param Converter to be add
     * @return void
     */
    public function add(ParamConverterInterface $paramConverter): void
    {
        $this->converters[] = $paramConverter;
    }

    /**
     * Returns all the registered param converters
     *
     * @return \ParamConverter\ParamConverterInterface[]
     */
    public function all(): array
    {
        return $this->converters;
    }

    /**
     * Applies all the registered converters to the specified request
     *
     * @param \Cake\Http\ServerRequest $request Request to be updated (replace params with objects)
     * @param string $controller Controller name
     * @param string $action action name
     * @return \Cake\Http\ServerRequest
     * @throws \ReflectionException
     */
    public function apply(ServerRequest $request, string $controller, string $action): ServerRequest
    {
        $method = new ReflectionMethod($controller, $action);
        $methodParams = $method->getParameters();
        $requestParams = $request->getParam('pass');

        $stopAt = min(count($methodParams), count($requestParams));
        for ($i = 0; $i < $stopAt; $i++) {
            $methodParam = $methodParams[$i];
            $requestParam = $requestParams[$i];

            if (!empty($methodParam->getClass())) {
                $requestParams[$i] = $this->convertParam($requestParam, $methodParam->getClass()->getName());
            } elseif (!empty($methodParam->getType())) {
                $requestParams[$i] = $this->convertParam($requestParam, $methodParam->getType()->getName());
            }
        }

        return $request->withParam('pass', $requestParams);
    }

    /**
     * Converts the specified string value to the specified class
     *
     * @param string $value Raw value to be converted to a class
     * @param string $class Target class
     * @return mixed
     */
    private function convertParam(string $value, string $class)
    {
        foreach ($this->all() as $converter) {
            if ($converter->supports($class)) {
                return $converter->convertTo($value, $class);
            }
        }

        return $value;
    }
}
