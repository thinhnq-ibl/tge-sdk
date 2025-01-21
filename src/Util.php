<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class Util
{
    public static function createCheckSum($secretKey, $method, $apiUri, $body, $nonce)
    {
        $message = $apiUri . $method . json_encode($body) . $nonce;
        $checksum = hash_hmac('sha256', $message, $secretKey);
        return $checksum;
    }

    public static function getMessage($uri, $client, $apiKey)
    {
        $response = $client->get($uri, [
            "headers" => [
                "x-api-key" => $apiKey
            ]
        ]);
        return $response->getBody();
    }

    public static function postMessage($uri, $body, $nonce, $checksum, $client, $apiKey)
    {
        $response = $client->post($uri, [
            'json' => $body,
            'headers' => [
                'x-api-key' => $apiKey,
                'x-nonce' => $nonce,
                'x-checksum' => $checksum
            ]
        ]);
        return $response->getBody();
    }
}