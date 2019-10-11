<?php

namespace App\Services;

use Curl\Curl;

class TelegramBot
{
    protected $token;
    protected $url = 'https://api.telegram.org/bot<token>/METHOD_NAME';

    private $curl;
    private $store;

    private $offset;

    /**
     * TelegramBot constructor.
     * @throws \ErrorException
     */
    public function __construct()
    {
        $this->store = new Store(new FileStore('offset.txt'));
        $offset = $this->store->get()['offset'] ?? 0;
        $this->offset = $offset;
        $this->token = getenv( 'TELEGRAM_BOT_TOKEN' );
        $this->url   = str_replace( '<token>', $this->token, $this->url );
        $this->curl  = new Curl();
    }

    /**
     * @param $method
     * @param array $params
     * @return mixed
     */
    public function query( $method, $params = [] )
    {
        $url = str_replace( 'METHOD_NAME', $method, $this->url );
        if ( !empty( $params ) ) {
            $url .= "?" . http_build_query( $params );
        }

        $content = $this->curl->get( $url )->getResponse();

        return json_decode( $content );
    }

    /**
     * @return mixed
     */
    public function getUpdates()
    {
        $response = $this->query( 'getUpdates', [
            'offset' => $this->offset + 1
        ] );

        if(!empty($response->result)) {
            $this->offset = $response->result[count($response->result)-1]->update_id;
            $this->store->set(['offset'=>$this->offset]);
        }

        return $response->result;
    }

    /**
     * @param $chat_id
     * @param $text
     * @return mixed
     */
    public function sendMessage( $chat_id, $text )
    {
        $response = $this->query( 'sendMessage', [
            'chat_id' => $chat_id,
            'text'    => $text
        ] );

        return $response;
    }

}
