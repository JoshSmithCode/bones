<?php

namespace Console\Commands;

use CLIFramework\Command;

class AbstractCommand extends Command
{

    public function logInfo(string $string): void
    {
        $this->getLogger()->info($string);
    }

    public function logError(string $string): void
    {
        $this->getLogger()->error($string);
    }
}