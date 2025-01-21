<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class UserService
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

    public function signMessage($address)
    {
        return Util::getMessage("/user/sign-message/" . $address, $this->client, $this->apiKey);
    }

    public function verifySignation($address, $signature)
    {
        $nonce = time();
        $body = ['address' => $address, 'signature' => $signature];
        $checksum = Util::createCheckSum($this->apiSecret, 'POST', $this->baseUri . '/user/check/old-password', $body, $nonce);
        return Util::postMessage("/user/check/old-password", $body, $nonce, $checksum, $this->client, $this->apiKey);
    }

    public function signup($username, $password, $firstName, $lastName, $email, $walletAddress)
    {
        $nonce = time();
        $body = ['username' => $username, 'password' => $password, 'firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'walletAddress' => $walletAddress];
        $checksum = Util::createCheckSum($this->apiSecret, 'POST', $this->baseUri . '/user/signup', $body, $nonce);
        return Util::postMessage("/user/signup", $body, $nonce, $checksum, $this->client, $this->apiKey);
    }
}