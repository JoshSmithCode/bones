<?php

namespace App\Http;

use App\Bones;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

class Main extends Bones
{
    public function handleRequest(Request $request)
    {
        $container = $this->getContainer();

        $container->store(Request::class, $request);

        $container->bind(SessionStorageInterface::class, NativeSessionStorage::class);

        ## A router based on FastRoute that stores all the different url's we'll respond to
        $router = new Router($container);

        ## Another handy function to store the routes, jump over to Routes.php to add them
        (new Routes)->addRoutes($router);

        ## The router will take the $request and see if it can send it into a controller
        $response = $router->dispatch($request);

        ## We're all done here!
        $response->send();
    }
}
