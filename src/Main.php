<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;

class Main
{

    public function handleRequest()
    {
        $container = new Container;

        $this->handleDependencies($container);

        $router = new Router($container);

        $router->addRoutes();

        $response = $router->dispatch(Request::createFromGlobals());

        $response->send();
    }

    private function handleDependencies(Container $container)
    {

    }
}