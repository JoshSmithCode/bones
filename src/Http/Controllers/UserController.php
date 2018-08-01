<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    public function profile()
    {
        Return new Response("Welcome back!");
    }
}