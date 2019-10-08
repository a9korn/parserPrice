<?php

namespace App\Services;

use App\Interfaces\IMarketplace;
use Curl\Curl;

class GStore implements IMarketplace
{
    private $IPHONE11_URL           = 'https://g-store.com.ua/apple-iphone-11-pro/';
    private $iphone11_green_regexp  = '#data-product-id=\\\&quot;9700\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is';
    private $iphone11_silver_regexp = '#data-product-id=\\\&quot;9704\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is';

    const IPHONE1_GREEN  = 'iphone11green';
    const IPHONE1_SILVER = 'iphone11silver';

    private $iphone;
    private $cache;

    public function __construct( $iphone )
    {
        $this->iphone = $iphone;
    }

    public function getPrice()
    {
        return $this->parsePrice();
    }

    private function parsePrice()
    {
        if ( empty( $this->cache ) ) {
            $curl    = new Curl();
            $content = $curl->get( $this->IPHONE11_URL )->getResponse();
            $this->cache = $content;
            $curl->close();
        } else {
            $content = $this->cache;
        }

        switch ( $this->iphone ) {
            case self::IPHONE1_GREEN:
                $price = $this->getIphone11Green( $content );
                break;
            case self::IPHONE1_SILVER:
                $price = $this->getIphone11Silver( $content );
                break;
            default:
                $price = null;
        }

        return $price;
    }

    private function getIphone11Green( $content )
    {
        return $this->regexp( $content, $this->iphone11_green_regexp );
    }

    private function getIphone11Silver( $content )
    {
        return $this->regexp( $content, $this->iphone11_silver_regexp );
    }


    private function regexp( $content, $regexp )
    {
        preg_match( $regexp, $content, $result );
        if ( !empty( $result[ 1 ] ) ) $price = (int)trim( $result[ 1 ] );

        return $price ?? null;
    }
}
