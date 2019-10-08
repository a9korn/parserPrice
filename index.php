<?php

use PhpQuery\PhpQuery;

require __DIR__ . '/vendor/autoload.php';

$curl = new Curl\Curl();
$content = $curl->get('https://g-store.com.ua/apple-iphone-11-pro/');

$page = $content->getResponse();
$curl->close();



dd(trim($result[1]));

//file_put_contents('test.txt',$page);
//$pq=new PhpQuery;
//$pq->load_str($page);

//$res = $pq->query('.woocommerce-Price-amount.amount.final-price');

//foreach ($res as $item) {
//    print_r($item); echo '<br>';
//}
//echo $page;

