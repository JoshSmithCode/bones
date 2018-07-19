#!/usr/bin/env php
<?php

require 'vendor/autoload.php';
$app = new \Console\Main;
$app->runWithTry($argv);