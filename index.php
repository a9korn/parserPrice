<?php

use App\Services\FileStore;
use App\Services\GStore;
use App\Services\PriceChecker;
use App\Services\Store;

define( "DIR", __DIR__ );

require __DIR__ . '/vendor/autoload.php';

$store = new Store(new FileStore());

$checker      = new PriceChecker();
$price_silver = $checker->setMarketplace( new GStore( GStore::IPHONE1_SILVER ) )->getPrice();
$price_green  = $checker->setMarketplace( new GStore( GStore::IPHONE1_GREEN ) )->getPrice();

$store->set([
    'silver' => $price_silver,
    'green' => $price_green
]);

dd($store->get());
