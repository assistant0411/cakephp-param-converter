<?php

namespace ParamConverter\Test\TestCase;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use DateTime;
use ParamConverter\DispatchListener;
use ParamConverter\Test\App\Controller\UsersController;
use ParamConverter\Test\App\Model\Table\UsersTable;

class DispatchListenerTest extends TestCase
{
    public $fixtures = [
        'plugin.ParamConverter.Users',
    ];

    public function setUp()
    {
        parent::setUp();

        TableRegistry::getTableLocator()->set(
            'Users',
            TableRegistry::getTableLocator()->get('Users', ['className' => UsersTable::class])
        );
    }

    public function testScalar(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', ["true", "10", "10.5", "foo"])
            ->withParam('action', 'withScalar');
        $response = new Response();

        $listener = new DispatchListener();
        $listener->beforeDispatch($event, $request, $response);

        /** @var ServerRequest $updatedRequest */
        $updatedRequest = $event->getData('request');
        $this->assertSame($updatedRequest->getParam('pass.0'), (bool) true);
        $this->assertSame($updatedRequest->getParam('pass.1'), (int) 10);
        $this->assertSame($updatedRequest->getParam('pass.2'), (float) 10.5);
        $this->assertSame($updatedRequest->getParam('pass.3'), (string) "foo");
    }

    public function testDatetime(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', ["2020-10-10"])
            ->withParam('action', 'withDatetime');
        $response = new Response();

        $listener = new DispatchListener();
        $listener->beforeDispatch($event, $request, $response);

        /** @var ServerRequest $updatedRequest */
        $updatedRequest = $event->getData('request');
        $this->assertTrue($updatedRequest->getParam('pass.0') instanceof Datetime);
    }

    public function testEntity(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', ["00000000-0000-0000-0000-000000000001"])
            ->withParam('action', 'withEntity');
        $response = new Response();

        $listener = new DispatchListener();
        $listener->beforeDispatch($event, $request, $response);

        /** @var ServerRequest $updatedRequest */
        $updatedRequest = $event->getData('request');
        $this->assertTrue($updatedRequest->getParam('pass.0') instanceof EntityInterface);
    }

    public function testActionNoParams(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', [])
            ->withParam('action', 'withNoParams');
        $response = new Response();

        $listener = new DispatchListener();
        $listener->beforeDispatch($event, $request, $response);

        /** @var ServerRequest $updatedRequest */
        $updatedRequest = $event->getData('request');
        $this->assertEquals([], $updatedRequest->getParam('pass'));
    }

    public function testActionNoTypehint(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', ["1", "2", "3"])
            ->withParam('action', 'withNoTypehint');
        $response = new Response();

        $listener = new DispatchListener();
        $listener->beforeDispatch($event, $request, $response);

        /** @var ServerRequest $updatedRequest */
        $updatedRequest = $event->getData('request');
        $this->assertEquals(["1", "2", "3"], $updatedRequest->getParam('pass'));
    }

    public function testUndefinedAction(): void
    {
        $event = new Event('beforeEvent');
        $event->setData('controller', new UsersController());

        $request = (new ServerRequest())
            ->withParam('pass', [])
            ->withParam('action', 'undefined');
        $response = new Response();

        $listener = new DispatchListener();

        $this->expectException(\ReflectionException::class);
        $listener->beforeDispatch($event, $request, $response);
    }
}
