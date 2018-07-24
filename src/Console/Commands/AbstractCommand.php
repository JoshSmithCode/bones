<?php

namespace App\Console\Commands;


use App\Console\Main;
use League\CLImate\CLImate;

abstract class AbstractCommand implements CommandInterface
{

    protected $arguments;

    /**
     * @var Main
     */
    protected $app;

    public function logInfo(string $string, string $color = 'white'): void
    {
        (new CLImate)->$color()->out($string);
    }

    public function logError(string $string): void
    {
        (new CLImate)->red()->out($string);
    }

    public function arguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    function init(Main $app): void
    {
        $this->app = $app;
    }
}