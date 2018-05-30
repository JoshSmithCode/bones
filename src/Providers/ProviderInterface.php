<?php

namespace App\Providers;

use App\Container;

interface ProviderInterface
{
    public function build(Container $container);
}