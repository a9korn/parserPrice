<?php


namespace App\Services;


use App\Interfaces\IStore;

class FileStore implements IStore
{
    private $fname;

    public function __construct( $fname = null)
    {
        $dir = DIR . DIRECTORY_SEPARATOR . getenv('STORE');

        if (!is_dir($dir)) {
            mkdir($dir);
        }

        if(!$fname) {
            $this->fname = $dir . DIRECTORY_SEPARATOR . 'store.txt';
        } else {
            $this->fname = $dir . DIRECTORY_SEPARATOR . $fname;
        }
    }

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