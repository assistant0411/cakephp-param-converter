<?php

namespace ParamConverter;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\ControllerFactory;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use DateTime;
use ReflectionException;
use ReflectionMethod;

/**
 * Listens to 'beforeDispatch' event and applies the parameter convertion
 *
 * @package ParamConverter
 */
class DispatchListener implements EventListenerInterface
{
    /**
     * @return mixed[]
     */
    public function implementedEvents()
    {
        return [
            'Dispatcher.beforeDispatch' => 'beforeDispatch',
        ];
    }

    /**
     * @param \Cake\Event\Event $beforeEvent Before Dispatch Event instance
     * @param \Cake\Http\ServerRequest $request Current request which includes the passed parameters
     * @param \Cake\Http\Response $response Response created
     * @return void
     */
    public function beforeDispatch(Event $beforeEvent, ServerRequest $request, Response $response): void
    {
        // Use the controller built by an beforeDispatch
        // event handler if there is one.
        if ($beforeEvent->getData('controller') instanceof Controller) {
            $controller = $beforeEvent->getData('controller');
        } else {
            $factory = new ControllerFactory();
            $controller = $factory->create($request, $response);
        }

        $action = $request->getParam('action');
        try {
            $method = new ReflectionMethod($controller, $action);
            $methodParams = $method->getParameters();
            $requestParams = $request->getParam('pass');

            $stopAt = min(count($methodParams), count($requestParams));
            for ($i = 0; $i < $stopAt; $i++) {
                $methodParam = $methodParams[$i];
                $requestParam = $requestParams[$i];

                $methodParamClass = $methodParam->getClass();
                $methodParamType = $methodParam->getType();
                if (empty($methodParamClass) && empty($methodParamType)) {
                    continue;
                }

                if (!empty($methodParamClass) && $methodParamClass->isSubclassOf(Entity::class)) {
                    $table = TableRegistry::getTableLocator()->get(
                        Inflector::tableize($methodParamClass->getShortName())
                    );

                    $requestParams[$i] = $table->get($requestParam);
                } elseif (!empty($methodParamClass) && $methodParamClass->getName() === DateTime::class) {
                    $requestParams[$i] = new DateTime($requestParam);
                } elseif (!empty($methodParamType)) {
                    settype($requestParam, $methodParamType->getName());
                    $requestParams[$i] = $requestParam;
                }
            }

            $beforeEvent->setData('request', $request->withParam('pass', $requestParams));
        } catch (ReflectionException $e) {
            return;
        }
    }
}
