<?php

namespace ParamConverter;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\ControllerFactory;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

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
        $manager = new ParamConverterManager([
            new EntityParamConverter(),
            new DateTimeParamConverter(),
        ]);

        $request = $manager->apply($request, get_class($controller), $action);

        $beforeEvent->setData('request', $request);
    }
}
