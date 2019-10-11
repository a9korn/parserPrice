<?php

namespace App\Services\Marketplaces;

use App\Interfaces\IMarketplace;
use Curl\Curl;

class GStore implements IMarketplace
{
    private $IPHONE11_URL           = 'https://g-store.com.ua/apple-iphone-11-pro-max/';
    private $iphone11_green_regexp  = '#data-product-id=\\\&quot;9680\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is';
    private $iphone11_silver_regexp = '#data-product-id=\\\&quot;9686\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is';
    private $iphone11_gold_regexp   = '#data-product-id=\\\&quot;9683\\\&quot;&gt;\\\n                                            &lt;span class=\\\&quot;woocommerce-Price-amount amount final-price\\\&quot;&gt;(.+?)&amp;nbsp;\\\n#is';

    const IPHONE11_GREEN  = 'iphone11green';
    const IPHONE11_SILVER = 'iphone11silver';
    const IPHONE11_GOLD = 'iphone11gold';

    private $iphone;
    private $cache;

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
        if ( empty( $this->cache ) ) {
            $curl        = new Curl();
            $content     = $curl->get( $this->IPHONE11_URL )->getResponse();
            $this->cache = $content;
            $curl->close();
        } else {
            $content = $this->cache;
        }

        switch ( $this->iphone ) {
            case self::IPHONE11_GREEN:
                $price = $this->getIphone11Green( $content );
                break;
            case self::IPHONE11_SILVER:
                $price = $this->getIphone11Silver( $content );
                break;
            case self::IPHONE11_GOLD:
                $price = $this->getIphone11Gold( $content );
                break;
            default:
                $price = null;
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

        if ( !empty( $result[ 1 ] ) ) {
            $price = (float)trim( $result[ 1 ] );
        }

        return $price ?? 0;
    }
}
