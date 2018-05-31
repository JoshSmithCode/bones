<?php


use Symfony\Component\HttpFoundation\Request;

use App\Main;

require __DIR__ . '/../vendor/autoload.php';

(new Main)->handleRequest(Request::createFromGlobals());
