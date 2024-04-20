<?php

namespace App\API;

use GuzzleHttp\Client;

class GuzzleClientApi
{
    public static function getGuzzleClient()
    {
        return new Client();
    }

    public static function getGuzzleClientWithHeaders()
    {
        return new Client(['headers' => ['Content-Type' => 'application/json']]);
    }

    public static function getGuzzleClientWithHeadersAndAuth()
    {
        return new Client(['headers' => ['Content-Type' => 'application/json'], 'auth' => ['test', 'test']]);
    }

    public static function getRequest($url)
    {
        $client = self::getGuzzleClient();
        $response = $client->request('GET', $url);
        return $response->getBody()->getContents();
    }

    public static function postRequest($url, $data)
    {
        $client = self::getGuzzleClientWithHeaders();
        $response = $client->request('POST', $url, ['json' => $data]);
        return $response->getBody()->getContents();
    }
}
