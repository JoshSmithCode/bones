<?php

namespace App\Console\Commands;

interface CommandInterface
{
    public function brief(): string;

    public function execute();
}