<?php

namespace App\Console;

use App\Bones;
use App\Console\Commands\AbstractCommand;

class Main extends Bones
{

    private $commands = [];

    public function run($argv)
    {
        $this->registerCommands();

        $consoleInit = array_shift($argv);
        $commandName = array_shift($argv);

        if(is_null($commandName))
        {
            $commandName = "help";
        }

        if(!isset($this->commands[$commandName]))
        {
            echo "A command with the name '" . $commandName . "' could not be found, make sure it's been registered";die;
        }

        $command = $this->commands[$commandName];

        $command->init($this);

        $command->arguments($argv);

        $command->execute();
    }

    private function registerCommands(): void
    {
        $this->addCommand('help', 'App\Console\Commands\HelpCommand');
        $this->addCommand('example', 'App\Console\Commands\ExampleCommand');
    }

    private function addCommand(string $name, string $class)
    {
        $this->commands[$name] = $this->buildCommand($class);
    }

    private function buildCommand(string $class): AbstractCommand
    {
        $command = $this->getContainer()->get($class);

        if($command instanceof AbstractCommand)
        {
            return $command;
        }

        echo "The command '" . $class . "' needs to implement the `CommandInterface`.";die;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }
}