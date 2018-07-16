<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;

class Main
{
    public function handleRequest(Request $request)
    {
        ## Dependency Injection is convenient, let's use a Container
        $container = new Container;

        ## This config class makes sure we always have access to the config we want. Jump over to Config.php
        #  to set up any additional config you might need
        $container->store('config', new Config);

        $container->store(Request::class, $request);

        ## A handy little function to register dependencies for the Container. Jump over to Dependencies.php to
        #  add any other dependencies you need. (Helps keep the 'use' imports up the top small here in main)
        (new Dependencies)->setupContainer($container);

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
