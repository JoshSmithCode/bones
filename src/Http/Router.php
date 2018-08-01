<?php

namespace App\Http;

use App\Container;
use Exception;

use Symfony\Component\HttpFoundation\Request;

use FastRoute\DataGenerator\GroupCountBased as GroupDataGenerator;
use FastRoute\Dispatcher\GroupCountBased as GroupDispatcher;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector as FastRouteCollector;
use FastRoute\RouteParser\Std;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

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

                [$controllerClass, $method, $public] = $handler;

                $session = $this->container->get(Session::class);
                if(!$session->get('user') && !$public)
                {
                    throw new Exception("You're not allowed in here!");
                }

                $controller = $this->container->get($controllerClass);
                $methodArgs = $this->container->getMethodArgs($controller, $method);

                $controller->params = $params;

                return $controller->$method(...$methodArgs);
        }
    }

     ##
     # Okay, so what's going on below? This looks like magic, right?
     #
     # This little set of four functions is just to help make things more readable.
     # The third thing we can pass to the handler is just a simple Boolean that tells the router whether or not the
     # route is public. For public routes, anyone can access them, for private routes, you'd need to be logged in.
     #
     # So why not just pass that in the routes? Well, a random boolean as the third item in the array is hard to explain.
     # We could give it a key like [ "public" => true ], but then it would feel like we need keys for the controller and method.
     #
     # To keep things simple, there's just two functions for the two main methods, post and get. All it does is add the
     # third key in the array. If you don't like these, just use the post/get functions yourself and set the bool. These
     # functions wont override settings from the Routes.php file.
     #
     ##

    public function publicPost(string $route, array $handler)
    {
        $handler[] = true;
        parent::post($route, $handler);
    }

    public function publicGet(string $route, array $handler)
    {
        $handler[] = true;
        parent::get($route, $handler);
    }

    public function post($route, $handler)
    {
        if(isset($handler[2]))
        {
            parent::post($route, $handler);
        }
        $handler[] = false;
        parent::post($route, $handler);
    }

    public function get($route, $handler)
    {
        if(isset($handler[2]))
        {
            parent::get($route, $handler);
        }
        $handler[] = false;
        parent::get($route, $handler);
    }
}