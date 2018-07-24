<?php

namespace App;

class Bones
{

    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        ## Dependency Injection is convenient, let's use a Container
        $this->container = new Container;

        ## This config class makes sure we always have access to the config we want. Jump over to Config.php
        #  to set up any additional config you might need
        $this->container->store('config', new Config);

        ## A handy little function to register dependencies for the Container. Jump over to Dependencies.php to
        #  add any other dependencies you need. (Helps keep the 'use' imports up the top small here in main)
        (new Dependencies)->setupContainer($this->container);
    }

    protected function getContainer(): Container
    {
        return $this->container;
    }
}
