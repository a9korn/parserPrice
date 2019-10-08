<?php

use App\Services\GStore;
use App\Services\PriceChecker;

require __DIR__ . '/vendor/autoload.php';

$checker = new PriceChecker();
$checker->setMarketplace(new GStore());

dd($checker->getPrice());


//file_put_contents('test.txt',$page);
//$pq=new PhpQuery;
//$pq->load_str($page);

//$res = $pq->query('.woocommerce-Price-amount.amount.final-price');

//foreach ($res as $item) {
//    print_r($item); echo '<br>';
//}
//echo $page;

