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
        $gstore_price_gold   = $this->setMarketplace( new GStore( GStore::IPHONE11_GOLD ) )->getPrice();

        $buyua_price_silver = $this->setMarketplace( new BuyUa( BuyUa::IPHONE11_SILVER ) )->getPrice();
        $buyua_price_green  = $this->setMarketplace( new BuyUa( BuyUa::IPHONE11_GREEN ) )->getPrice();
        $buyua_price_gold  = $this->setMarketplace( new BuyUa( BuyUa::IPHONE11_GOLD ) )->getPrice();


        $message = '';
        if ( $gstore_price_silver ) {
            $message = "GStore. 256Silver2SIM: " . $gstore_price_silver . " грн.\n";
            $message .= "GStore. 256Green2SIM: " . $gstore_price_green . " грн.\n";
            $message .= "GStore. 256Gold2SIM: " . $gstore_price_gold . " грн.\n";
        } else {
            $message = "GStore - не доступен\n";
        }

        $message .= "BuyUa. 256Silver2SIM: " . $buyua_price_silver . " грн.\n";
        $message .= "BuyUa. 256Green2SIM: " . $buyua_price_green . " грн.\n";
        $message .= "BuyUa. 256Gold2SIM: " . $buyua_price_gold . " грн.\n";

        return $message;
    }
}