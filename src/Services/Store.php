<?php


namespace App\Services;


use App\Interfaces\IStore;

class Store
{
    private $store;

    /**
     * Store constructor.
     * @param IStore $store
     */
    public function __construct( IStore $store )
    {
        $this->store = $store;
    }

    /**
     * @param $value
     */
    public function set( $value )
    {
        $this->store->set( $value );
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->store->get();
    }
}