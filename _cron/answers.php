<?php

use App\Services\PriceChecker;
use App\Services\TelegramBot;

require_once __DIR__ . "/../load.php";

$telegram_bot = new TelegramBot();

$updates = $telegram_bot->getUpdates();

foreach ( $updates as $update ) {
    $checker = new PriceChecker();
    $message = $checker->getMessage();

    $res = $telegram_bot->sendMessage( $update->message->chat->id, $message );
}
