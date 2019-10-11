<?php

use App\Services\PriceChecker;

require_once __DIR__ . "/load.php";

$checker = new PriceChecker();
$message = $checker->getMessage();

echo $message;
