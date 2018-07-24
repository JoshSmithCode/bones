<?php

namespace App\Console\Commands;

class ExampleCommand extends AbstractCommand
{

    public function brief(): string
    {
        return "A simple example command";
    }

    public function execute()
    {
        $this->logInfo("Your command here!", 'red');
    }
}