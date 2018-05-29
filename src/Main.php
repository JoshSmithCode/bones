<?php

namespace App;

use Exception;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

class Main
{

    public function handleRequest()
    {
        $config = $this->config();

        $container = new Container($config);

        $this->handleDependencies($container);

        $router = new Router($container);

        $router->addRoutes();

        $response = $router->dispatch(Request::createFromGlobals());

        $response->send();
    }

    private function handleDependencies(Container $container)
    {

    }

    private function config()
    {
        (new Dotenv)->load(dirname(__DIR__).'/.env');

        $config = [
            'APP_ENV',
            'DB_HOST',
        ];

        $envConfig = getenv();

        foreach($config as $item)
        {
            if(getenv($item) === false)
            {
                throw new Exception("Environment variable \"{$item}\" is missing");
            }

            $envConfig[$item] = getenv($item);
        }

        return $envConfig;
    }
}