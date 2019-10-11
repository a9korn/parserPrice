<?php

namespace App\Services\Marketplaces;

use App\Interfaces\IMarketplace;
use Curl\Curl;

class BuyUa implements IMarketplace
{
    private $IPHONE11_SILVER_URL    = 'http://www.buy.ua/shop/1400215/1400485/1716569.html';
    private $IPHONE11_GREEN_URL     = 'http://www.buy.ua/shop/1400215/1400485/1716554.html';
    private $IPHONE11_GOLD_URL      = 'http://www.buy.ua/shop/1400215/1400485/1716574.html';
    private $iphone11_green_regexp  = "#<div class=\"price-info\">(.+?)</strong>(.+?)грн.</div>#is";
    private $iphone11_silver_regexp = "#<div class=\"price-info\">(.+?)</strong>(.+?)грн.</div>#is";
    private $iphone11_gold_regexp   = "#<div class=\"price-info\">(.+?)</strong>(.+?)грн.</div>#is";

    const IPHONE11_GREEN  = 'iphone11green';
    const IPHONE11_SILVER = 'iphone11silver';
    const IPHONE11_GOLD   = 'iphone11gold';

    private $iphone;

    /**
     * GStore constructor.
     * @param $iphone
     */
    public function __construct( $iphone )
    {
        $this->iphone = $iphone;
    }

    /**
     * @return float
     * @throws \ErrorException
     */
    public function getPrice(): float
    {
        return $this->parsePrice();
    }

    /**
     * @return int|null
     * @throws \ErrorException
     */
    private function parsePrice()
    {
        switch ( $this->iphone ) {
            case self::IPHONE11_GREEN:
                $curl    = new Curl();
                $content = $curl->get( $this->IPHONE11_GREEN_URL )->getResponse();
                $curl->close();

                $price = $this->getIphone11Green( $content );
                break;
            case self::IPHONE11_SILVER:
                $curl    = new Curl();
                $content = $curl->get( $this->IPHONE11_SILVER_URL )->getResponse();
                $curl->close();

                $price = $this->getIphone11Silver( $content );
                break;
            case self::IPHONE11_GOLD:
                $curl    = new Curl();
                $content = $curl->get( $this->IPHONE11_GOLD_URL )->getResponse();
                $curl->close();

                $price = $this->getIphone11Gold( $content );
                break;
            default:
                $price = 0;
        }

        return $price;
    }

    /**
     * @param $content
     * @return int|null
     */
    private function getIphone11Green( $content )
    {
        return $this->regexp( $content, $this->iphone11_green_regexp );
    }

    /**
     * @param $content
     * @return int|null
     */
    private function getIphone11Gold( $content )
    {
        return $this->regexp( $content, $this->iphone11_gold_regexp );
    }

    /**
     * @param $content
     * @return int|null
     */
    private function getIphone11Silver( $content )
    {
        return $this->regexp( $content, $this->iphone11_silver_regexp );
    }

    /**
     * @param string $content
     * @param string $regexp
     * @return int|null
     */
    private function regexp( $content, $regexp )
    {
        preg_match( $regexp, $content, $result );
        if ( !empty( $result[ 2 ] ) ) $price = (float)trim( $result[ 2 ] );

        return $price ?? null;
    }
}
