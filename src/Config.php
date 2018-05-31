<?php

namespace App;

use Exception;
use Symfony\Component\Dotenv\Dotenv;

class Config
{
    /**
     * @var string
     */
    private $appEnv;

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPass;

    /**
     * @var string
     */
    private $dbName;

    public function __construct()
    {
        (new Dotenv)->load(dirname(__DIR__).'/.env');

        $this->setProperty('appEnv', 'APP_ENV');
        $this->setProperty('dbUser', 'DB_USER');
        $this->setProperty('dbPass', 'DB_PASS');
        $this->setProperty('dbName', 'DB_NAME');
    }

    private function setProperty(string $propertyName, string $envName)
    {
        $envValue = getenv($envName);

        if($envValue === false)
        {
            throw new Exception("Your config is trying to get something named {$envName} but it doesn't exist! Make sure it's in your .env file or server config");
        }
    }

    /**
     * @return string
     */
    public function getAppEnv(): string
    {
        return $this->appEnv;
    }

    /**
     * @return string
     */
    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    /**
     * @return string
     */
    public function getDbPass(): string
    {
        return $this->dbPass;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }
}