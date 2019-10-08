<?php
namespace App\Services;

use App\Interfaces\IMarketplace;

class PriceChecker
{
    /** @var IMarketplace $marketplace */
    protected $marketplace;

    public function setMarketplace( IMarketplace $marketplace )
    {
        $this->marketplace = $marketplace;
        return $this;
    }

    public function getPrice()
    {
        return $this->marketplace->getPrice();
    }
}