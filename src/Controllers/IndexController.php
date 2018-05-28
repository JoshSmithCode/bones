<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function index()
    {
        return new Response("Hello World");
    }
}