<?php

namespace App;

use Exception;

use Symfony\Component\HttpFoundation\Request;

use FastRoute\DataGenerator\GroupCountBased as GroupDataGenerator;
use FastRoute\Dispatcher\GroupCountBased as GroupDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector as FastRouteCollector;
use FastRoute\RouteParser\Std;

use App\Controllers\IndexController;
use Symfony\Component\HttpFoundation\Response;

class Router extends FastRouteCollector
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;

        parent::__construct(new Std, new GroupDataGenerator);
    }

    public function addRoutes()
    {
        $this->get('/home', [IndexController::class, 'index']);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function dispatch(Request $request) : Response
    {
        $dispatcher = new GroupDispatcher($this->getData());

        [$status, $handler, $params] = array_pad($dispatcher->dispatch($request->getMethod(), $request->getRequestUri()), 3, []);

        switch($status)
        {
            case Dispatcher::NOT_FOUND:
                throw new Exception("No route matching - " . $request->getRequestUri(), 404);

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new Exception("Method '{$request->getMethod()}' not allowed for route matching $request->getUri()", 405);

            case Dispatcher::FOUND:

                [$controllerClass, $method] = $handler;

                $controller = $this->container->get($controllerClass);
                $methodArgs = $this->container->getMethodArgs($controller, $method);

                $controller->params = $params;

                return $controller->$method(...$methodArgs);
        }
    }
}