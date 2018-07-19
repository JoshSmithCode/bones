<?php

namespace Console;
use CLIFramework\Application;
use GetOptionKit\OptionCollection;

class Main extends Application
{

    /* init your application options here */
    /**
     * @param OptionCollection $opts
     */
    public function options($opts)
    {
        $opts->add('v|verbose', 'verbose message');
    }

    /* register your command here */
    public function init()
    {
        $this->command( 'help', '\Console\Commands\HelpCommand' );
    }

}