<?php


namespace App\Services;


use App\Interfaces\IStore;

class Store
{
    private $store;

    public function __construct( IStore $store )
    {
        $this->store = $store;
    }

    public function set( $value )
    {
        $this->store->set( $value );
    }

    public function get()
    {
        return $this->store->get();
    }
}