<?php

use App\Services\GStore;
use App\Services\PriceChecker;

require __DIR__ . '/vendor/autoload.php';

$checker = new PriceChecker();
$checker->setMarketplace(new GStore());

dd($checker->getPrice());
