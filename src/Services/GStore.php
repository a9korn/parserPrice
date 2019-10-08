<?php


class GStore implements Marketplace
{
    const IPHONE11 = 'https://g-store.com.ua/apple-iphone-11-pro/';

    private $price;

    public function getPrice()
    {
        return $this->price;
    }

    private function parsePrice()
    {
        preg_match( '#data-product-id=\\\&quot;9700\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is', $page, $result );
        $this->price = trim($result[1]);
    }
}
