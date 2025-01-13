<?php

namespace Thinhnguyen\TgeSdk;
use GuzzleHttp\Client;

class ApiService
{
    private $client;
    private $apiKey;
    private $apiSecret;
    private $baseUri;

    public function __construct($baseUri, $apiKey, $apiSecret)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->baseUri = $baseUri;
    }

    public function getData()
    {
        $response = $this->client->get("/get", [
            "headers" => [
                "x-api-key" => $this->apiKey
            ]
        ]);
        return $response->getBody();
    }

    public function putJsonData()
    {
        $nonce = time();
        $checksum = $this->createCheckSum($this->apiSecret, 'PUT', `$this->baseUri/put`, ['foo' => 'bar'], $nonce);
        $response = $this->client->put("/put", [
            'json' => ['foo' => 'bar'],
            'headers' => [
                'x-api-key' => $this->apiKey,
                'x-api-nonce' => $nonce,
                'x-api-checksum' => $checksum
            ]
        ]);
        return $response->getBody();
    }



    public function createCheckSum($secretKey, $method, $apiUri, $body, $nonce)
    {
        $message = $apiUri . $method . json_encode($body) . $nonce;
        $checksum = hash_hmac('sha256', $message, $secretKey);
        return $checksum;
    }
}