<?php


class PriceChecker
{
    private $marketplace;

    public function setMarketplace( Marketplace $marketplace)
    {
        $this->marketplace = $marketplace;
    }
}