<?php

namespace App\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use App\Container;

class EntityManagerProvider implements ProviderInterface
{

    public function build(Container $container)
    {
        $paths = [dirname(__DIR__) . "/Entities"];
        $isDevMode = $container->getConfig('APP_ENV') == 'development';

        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => $container->getConfig('DB_USER'),
            'password' => $container->getConfig('DB_PASS'),
            'dbname'   => $container->getConfig('DB_NAME'),
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);

        $config->setNamingStrategy(new BonesNamingStrategy);

        return EntityManager::create($dbParams, $config);
    }
}