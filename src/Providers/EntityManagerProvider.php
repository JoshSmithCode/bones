<?php

namespace App\Providers;

use App\Config;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

use App\Container;

class EntityManagerProvider implements ProviderInterface
{

    public function build(Container $container)
    {
        $paths = [dirname(__DIR__) . "/Entities/"];

        /** @var Config $config */
        $config = $container->get('config');

        $isDevMode = $config->getAppEnv() == 'development';

        $dbParams = [
            'driver'   => 'pdo_mysql',
            'UserEntity'     => $config->getDbUser(),
            'password' => $config->getDbPass(),
            'dbname'   => $config->getDbName(),
            'host'     => $config->getDbHost(),
        ];

        $metadataConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $metadataConfig->newDefaultAnnotationDriver($paths);

        return EntityManager::create($dbParams, $metadataConfig);
    }
}