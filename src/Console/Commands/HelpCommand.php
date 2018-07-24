<?php

namespace App\Console\Commands;

class HelpCommand extends AbstractCommand
{
    public function brief(): string
    {
        return 'List the available commands';
    }

    function execute()
    {
        $commands = $this->app->getCommands();

        $this->logInfo('Welcome to the Bones Console. Available commands are:', 'green');

        /** @var AbstractCommand $command */
        foreach($commands as $name => $command)
        {
            $this->logInfo($name . " : " . $command->brief());
        }
    }
}