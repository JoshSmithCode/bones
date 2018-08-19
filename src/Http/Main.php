<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

use App\Bones;
use App\Config;

use Twig_Environment;
use Twig_Loader_Filesystem;

class Main extends Bones
{
    public function handleRequest(Request $request)
    {
        $container = $this->getContainer();

        $container->store(Request::class, $request);

        $container->bind(SessionStorageInterface::class, NativeSessionStorage::class);

        /** @var Config $config */
        $config = $container->get('config');

        ## We're going to load Twig here. It's a nicer way to do templating, rather than just writing plain php/html
        $twigFileLoader = new Twig_Loader_Filesystem(realpath(__DIR__) . "/../View/Templates/");
        $twig = new Twig_Environment($twigFileLoader, ['debug' => $config->getAppEnv() == 'development']);

        $container->store(Twig_Environment::class, $twig);

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
