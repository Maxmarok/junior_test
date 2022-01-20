<?php

/*
 * Copyright (c) YukiDub. Author: Daniil <den4ic2001@gmail.com>.
 *
 * 14.1.2022
 */

namespace App\Services\ParserPeak;

use Illuminate\Support\Facades\Http;

class Parser
{
    protected $url = "https://parser.peak.promo";

    public function __construct()
    {

    }

    function send($method, $url, $params){
        $response = Http::$method($this->url . $url , $params);

        if ($response->failed()) {
            return [];
        }
        return $response->json();
    }

    /**
     * @param $url
     */
    function getMusic($url)
    {
        $params = [
            'action'=> 'getMusic',
            'url'=> $url
        ];
        return $this->send('post', '', $params);
    }
}
