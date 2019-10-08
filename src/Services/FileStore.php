<?php


namespace App\Services;


use App\Interfaces\IStore;

class FileStore implements IStore
{
    private $fname = DIR . '/src/store/store.txt';

    public function set( array $value )
    {
        file_put_contents( $this->fname, json_encode( $value ) );
    }

    public function get(): array
    {
        $array = [];
        if ( file_exists( $this->fname ) ) {
            $json  = file_get_contents( $this->fname );
            $array = json_decode( $json, true );
        }

        return $array;
    }
}