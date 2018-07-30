<?php

use Symfony\Component\HttpFoundation\Request;

use App\Http\Main;

require __DIR__ . '/../vendor/autoload.php';

(new Main)->handleRequest(Request::createFromGlobals());
