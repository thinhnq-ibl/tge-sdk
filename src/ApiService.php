<?php

namespace Thinhnguyen\TgeSdk;
use GuzzleHttp\Client;

class ApiService
{
    private $client;

    public function __construct($baseUri)
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $baseUri,
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);

    }

    public function getData()
    {
        $response = $this->client->get("/get");
        return $response->getBody();
    }

    public function putJsonData()
    {
        $response = $this->client->put("/put", [
            'json' => ['foo' => 'bar']
        ]);
        return $response->getBody();
    }
}