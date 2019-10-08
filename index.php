<?php

use App\Services\FileStore;
use App\Services\GStore;
use App\Services\PriceChecker;
use App\Services\Store;
use App\Services\TelegramBot;

require_once __DIR__ . "/load.php";

$telegram_bot = new TelegramBot();
$store = new Store( new FileStore() );


//while ( true ) {
    $updates = $telegram_bot->getUpdates();

    foreach ( $updates as $update ) {
        $checker      = new PriceChecker();
        $price_silver = $checker->setMarketplace( new GStore( GStore::IPHONE1_SILVER ) )->getPrice();
        $price_green  = $checker->setMarketplace( new GStore( GStore::IPHONE1_GREEN ) )->getPrice();
        $message  = "iPhone 11 Pro 256Gb Midnight Green 2 SIM: " . $price_green . " грн.\n";
        $message .= "iPhone 11 Pro 256Gb Silver 2 SIM: " . $price_silver . " грн.\n";
        $res = $telegram_bot->sendMessage( $update->message->chat->id, $message );
    }
//    sleep(5);
//}

//$store = new Store( new FileStore() );
//
//$checker      = new PriceChecker();
//$price_silver = $checker->setMarketplace( new GStore( GStore::IPHONE1_SILVER ) )->getPrice();
//$price_green  = $checker->setMarketplace( new GStore( GStore::IPHONE1_GREEN ) )->getPrice();
//
//$store->set( [
//    'silver' => $price_silver,
//    'green'  => $price_green
//] );
//
//dd( $store->get() );
