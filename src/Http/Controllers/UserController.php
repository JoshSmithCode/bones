<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends AbstractController
{
    public function __construct(Session $session)
    {
        if(!$session->get('user'))
        {
            throw new \Exception("You're not allowed in here!");
        }
    }

    public function profile()
    {
        Return new Response("Welcome back!");
    }
}