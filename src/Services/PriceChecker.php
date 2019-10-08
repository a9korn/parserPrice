<?php
namespace App\Services;

use App\Interfaces\Marketplace;

class PriceChecker
{
    private $marketplace;

    public function setMarketplace( Marketplace $marketplace )
    {
        $this->marketplace = $marketplace;
    }

    public function getPrice()
    {
        return $this->marketplace->getPrice();
    }
}