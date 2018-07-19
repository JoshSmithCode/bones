<?php

namespace Console\Commands;

class HelpCommand extends AbstractCommand
{
    public function brief()
    {
        return 'Helpful Bones';
    }

    function init()
    {
        // register your subcommand here ..
    }

    function options($opts)
    {
        // command options
    }

    function execute()
    {
        $this->logInfo('Welcome to the Bones Console. Available commands are:');

        foreach($this->getVisibleCommands() as $command)
        {
            $this->logInfo($command);
        }
    }
}