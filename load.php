<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

define( "DIR", __DIR__ );

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
