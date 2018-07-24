<?php

namespace App\Http;

use Exception;

use Symfony\Component\HttpFoundation\Request;

use FastRoute\DataGenerator\GroupCountBased as GroupDataGenerator;
use FastRoute\Dispatcher\GroupCountBased as GroupDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector as FastRouteCollector;
use FastRoute\RouteParser\Std;

use App\Controllers\PublicController;
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

    /**
     * This is where we match up the URI to the controllers.
     *
     * If you came here from Routes.php because you're interested in changing the shape of our handlers,
     * you can see what we're doing below.
     *
     * $handler is the array we built in Routes.php for each of our routes. We use it by grabbing $controllerClass and
     * $method out of it, then we use the container to get the Controller and whatever arguments the $method needs
     * and the final step is to just call that method on the controller.
     *
     * If you want to change anything about the $handler, here and your Routes.php are the place to do it, but
     * this seems like a sensible default
     *
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