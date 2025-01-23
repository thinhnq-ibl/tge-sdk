<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class SubGraphService
{
    private $client;
    private $apiKey;
    private $apiSecret;
    private $baseUri;
    private $httpService;

    public function __construct()
    {
        $this->apiKey = $_ENV["SDK_TGE_API_KEY"];
        $this->apiSecret = $_ENV["SDK_TGE_SECRET_KEY"];
        $this->baseUri = $_ENV["SDK_TGE_API_BASE_URI"];
        $this->httpService = new HttpService();
    }

    /* 
     * Get health check from the API
     * @return object
     */
    public function healthCheck()
    {
        return $this->httpService->getMessage("/subgraph/healthcheck");
    }

    /* 
     * Get a query from the API
     * @param string $query
     * @param array $variables
     * @return object
     */
    public function query($query, $variables)
    {
        $originUri = "/subgraph/query";
        $nonce = time();
        $body = ['query' => $query, 'variables' => $variables];
        $checksum = $this->httpService->createCheckSum(
            $this->apiSecret,
            'POST',
            $this->baseUri . $originUri,
            $body,
            $nonce
        );
        return $this->httpService->postMessage(
            $originUri,
            $body,
            $nonce,
            $checksum
        );
    }
}