<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Migrations\Provider\OrmSchemaProvider;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\ORM\EntityManager;

class GenerateMigrationCommand extends AbstractCommand
{

    public function __construct(EntityManager $entityManager)
    {
        $fromSchema = $entityManager->getConnection()->getSchemaManager()->createSchema();
        $toSchema = (new OrmSchemaProvider($entityManager))->createSchema();

        ## looks pretty simple, implement DIFF as doctrine ORM Cli does, then handle migration files
        # using Doctrine DB connection
    }

    public function brief(): string
    {
        return "Used to generate migrations based on Doctrine Schema";
    }

    public function execute()
    {

    }
}