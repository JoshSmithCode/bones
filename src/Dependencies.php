<?php

namespace App;

use App\Providers\EntityManagerProvider;
use Doctrine\ORM\EntityManager;

class Dependencies
{
    public function setupContainer(Container $container)
    {
        ## What's an EntityManager? It's an important part of the Doctrine ORM
        ##
        ## ...What's the Doctrine ORM? An ORM is an Object Relational Mapper, it's a handy way to manage
        ## your database using PHP code. Doctrine's in here by default, but if you don't need it (or don't want it),
        ## just delete the line below and also nuke the Entities/ and Repositories/ folders.
        ##
        ## (Really though, have a look at https://www.doctrine-project.org, I think it's pretty cool for databases)
        $container->register(EntityManager::class, new EntityManagerProvider);
    }
}