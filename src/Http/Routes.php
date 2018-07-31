<?php

namespace App\Http;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;

class Routes
{

    /**
     * A convenient place to add routes to the router.
     *
     * The router provides a few convenience functions, like $router->get(); for GET requests, or $router->post() for POST...
     * you get the picture.
     *
     * The first argument is just the URI you want to match, if your site is http://bones.com/ a "/home" will match
     * the URL http://bones.com/home
     *
     * The second argument is how our dispatcher will know what to do. It's just an array where the first thing is the
     * controller class, and the second thing is the controller function we want to handle the request
     *
     * (If you don't like that, just have a look at the Router 'dispatch' function, you can change the shape there)
     *
     * @param Router $router
     */
    public function addRoutes(Router $router)
    {
        $router->get('/', [PublicController::class, 'index']);

        $router->post('/signup', [PublicController::class, 'signup']);

        $router->post('/login', [PublicController::class, 'login']);

        $router->get('/profile', [UserController::class, 'profile']);
    }
}