<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class HttpService
{
    private $client;
    private $apiKey;
    private $apiSecret;
    private $baseUri;

    public function __construct()
    {
        $this->apiKey = $_ENV["SDK_TGE_API_KEY"];
        $this->apiSecret = $_ENV["SDK_TGE_SECRET_KEY"];
        $this->baseUri = $_ENV["SDK_TGE_API_BASE_URI"];
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->baseUri,
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);
    }

    /* 
     * Create a checksum for the request
     * @param string $secretKey
     * @param string $method
     * @param string $apiUri
     * @param array $body
     * @param int $nonce
     * @return string
     */
    public function createCheckSum(
        $secretKey,
        $method,
        $apiUri,
        $body,
        $nonce
    ) {
        $message = $apiUri . $method . json_encode($body) . $nonce;
        $checksum = hash_hmac('sha256', $message, $secretKey);
        return $checksum;
    }

    /* 
     * Get a message from the API
     * @param string $uri
     * @return string
     */
    public function getMessage($uri)
    {
        $response = $this->client->get($uri, [
            "headers" => [
                "x-api-key" => $this->apiKey
            ]
        ]);
        return $response->getBody();
    }

    /* 
     * Post a message to the API
     * @param string $uri
     * @param array $body
     * @param int $nonce
     * @param string $checksum
     * @return string
     */
    public function postMessage(
        $uri,
        $body,
        $nonce,
        $checksum
    ) {
        $response = $this->client->post($uri, [
            'json' => $body,
            'headers' => [
                'x-api-key' => $this->apiKey,
                'x-nonce' => $nonce,
                'x-checksum' => $checksum
            ]
        ]);
        return $response->getBody();
    }

    /* 
     * Patch a message to the API
     * @param string $uri
     * @param array $body
     * @param int $nonce
     * @param string $checksum
     * @return string
     */
    public function patchMessage(
        $uri,
        $body,
        $nonce,
        $checksum
    ) {
        $response = $this->client->patch($uri, [
            'json' => $body,
            'headers' => [
                'x-api-key' => $this->apiKey,
                'x-nonce' => $nonce,
                'x-checksum' => $checksum
            ]
        ]);
        return $response->getBody();
    }

    /* 
     * Delete a message from the API
     * @param string $uri
     * @param array $body
     * @param int $nonce
     * @param string $checksum
     * @return string
     */
    public function deleteMessage(
        $uri,
        $body,
        $nonce,
        $checksum
    ) {
        $response = $this->client->delete($uri, [
            'json' => $body,
            'headers' => [
                'x-api-key' => $this->apiKey,
                'x-nonce' => $nonce,
                'x-checksum' => $checksum
            ]
        ]);
        return $response->getBody();
    }
}