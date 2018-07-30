<?php

namespace App\Console\Commands;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Migrations\Provider\OrmSchemaProvider;
use Doctrine\ORM\EntityManager;

class MigrateDatabaseCommand extends AbstractCommand
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function brief(): string
    {
        return "Used to migrate the database to match your Doctrine Entities";
    }

    public function execute()
    {
        $fromSchema = $this->entityManager->getConnection()->getSchemaManager()->createSchema();
        $toSchema = (new OrmSchemaProvider($this->entityManager))->createSchema();

        $upSql = $fromSchema->getMigrateToSql($toSchema, $this->entityManager->getConnection()->getDatabasePlatform());

        if(!$upSql)
        {
            $this->logSuccess('Database and Entities already synchronised, no migration needed');
        }

        $logFile = fopen('./logs/migration.log', 'a+');

        fwrite($logFile, "Logging Migration - \n\n");

        foreach($upSql as $query)
        {
            try
            {
                $this->entityManager->getConnection()->executeQuery($query);
                $now = date('Y-m-d H:i:s');

                $message = "Executed query '{$query}' successfully at {$now}";

                fwrite($logFile, $message . "\n\n");
                $this->logSuccess($message);
            }
            catch (DBALException $exception)
            {
                $message = "Executing query '{$query}' failed with message: {$exception->getMessage()}";

                fwrite($logFile, $message . "\n\n");
                $this->logError($message);
            }
        }

        fclose($logFile);
    }
}