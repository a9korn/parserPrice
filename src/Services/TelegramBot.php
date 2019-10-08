<?php

namespace App\Services;

use Curl\Curl;

class TelegramBot
{
    protected $token;
    protected $url = 'https://api.telegram.org/bot<token>/METHOD_NAME';

    private $curl;

    private $offset;

    public function __construct()
    {
        $this->token = getenv( 'TELEGRAM_TOKEN' );
        $this->url   = str_replace( '<token>', $this->token, $this->url );
        $this->curl  = new Curl();
    }

    public function query( $method, $params = [] )
    {
        $url = str_replace( 'METHOD_NAME', $method, $this->url );
        if ( !empty( $params ) ) {
            $url .= "?" . http_build_query( $params );
        }

        $content = $this->curl->get( $url )->getResponse();

        return json_decode( $content );
    }

    public function getUpdates()
    {
        $response = $this->query( 'getUpdates', [
            'offset' => $this->offset + 1
        ] );

        if(!empty($response->result)) {
            $this->offset = $response->result[count($response->result)-1]->update_id;
        }

        return $response->result;
    }

    public function sendMessage( $chat_id, $text )
    {
        $response = $this->query( 'sendMessage', [
            'chat_id' => $chat_id,
            'text'    => $text
        ] );

        return $response;
    }

}
