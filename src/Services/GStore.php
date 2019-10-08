<?php

namespace App\Services;

use App\Interfaces\Marketplace;
use Curl\Curl;

class GStore implements Marketplace
{
    const IPHONE11 = 'https://g-store.com.ua/apple-iphone-11-pro/';

    public function getPrice()
    {
        return $this->parsePrice();
    }

    private function parsePrice()
    {
        $curl = new Curl();
        $content = $curl->get(self::IPHONE11);

        $page = $content->getResponse();
        $curl->close();

        preg_match( '#data-product-id=\\\&quot;9700\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is', $page, $result );
        $price = trim($result[1]);

        return $price;
    }
}
