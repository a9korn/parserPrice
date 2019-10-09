<?php

namespace App\Services;

use App\Interfaces\IMarketplace;
use App\Services\Marketplaces\BuyUa;
use App\Services\Marketplaces\GStore;

class PriceChecker
{
    /** @var IMarketplace $marketplace */
    protected $marketplace;

    /**
     * @param IMarketplace $marketplace
     * @return $this
     */
    public function setMarketplace( IMarketplace $marketplace )
    {
        $this->marketplace = $marketplace;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->marketplace->getPrice();
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        $gstore_price_silver = $this->setMarketplace( new GStore( GStore::IPHONE11_SILVER ) )->getPrice();
        $gstore_price_green  = $this->setMarketplace( new GStore( GStore::IPHONE11_GREEN ) )->getPrice();

        $buyua_price_silver = $this->setMarketplace( new BuyUa( BuyUa::IPHONE11_SILVER ) )->getPrice();
        $buyua_price_green  = $this->setMarketplace( new BuyUa( BuyUa::IPHONE11_GREEN ) )->getPrice();


        $message = "GStore. iPhone 11 Pro 256Gb Silver 2 SIM: " . $gstore_price_silver . " грн.\n";
        $message .= "GStore. iPhone 11 Pro 256Gb Midnight Green 2 SIM: " . $gstore_price_green . " грн.\n";
        $message .= "BuyUa. iPhone 11 Pro 256Gb Silver 2 SIM: " . $buyua_price_silver . " грн.\n";
        $message .= "BuyUa. iPhone 11 Pro 256Gb Midnight Green 2 SIM: " . $buyua_price_green . " грн.\n";

        return $message;
    }
}