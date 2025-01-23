<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class SettingService
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
     * Get all setting from the API
     * @param string $key
     * @return object
     */
    public function getAll($key)
    {
        return $this->httpService->getMessage("/setting?key=" . $key);
    }

    /* 
     * Get a setting from the API
     * @param string $id
     * @return object
     */
    public function getSetting($id)
    {
        return $this->httpService->getMessage("/setting/" . $id);
    }

    /* 
     * Create a new setting
     * @param string $key
     * @param string $value
     * @param string $type
     * @param bool $isActive
     * @return object
     */
    public function newSetting(
        $key,
        $value,
        $type,
        $isActive = true
    ) {
        $originUri = "/setting";
        $nonce = time();
        $body = [
            'key' => $key,
            'value' => $value,
            'type' => $type,
            'isActive' => $isActive
        ];
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

    /* 
     * Update a setting
     * @param string $id
     * @param string $key
     * @param string $value
     * @param string $type
     * @param bool $isActive
     * @return object
     */
    public function updateSetting(
        $id,
        $key,
        $value,
        $type,
        $isActive = true
    ) {
        $originUri = "/setting/" . $id;
        $nonce = time();
        $body = [
            'key' => $key,
            'value' => $value,
            'type' => $type,
            'isActive' => $isActive
        ];
        $checksum = $this->httpService->createCheckSum(
            $this->apiSecret,
            'PATCH',
            $this->baseUri . $originUri,
            $body,
            $nonce
        );
        return $this->httpService->patchMessage(
            $originUri,
            $body,
            $nonce,
            $checksum
        );
    }

    /* 
     * Delete a setting
     * @param string $id
     * @return object
     */
    public function deleteSetting($id)
    {
        $originUri = "/setting/" . $id;
        $nonce = time();
        $body = [];
        $checksum = $this->httpService->createCheckSum(
            $this->apiSecret,
            'DELETE',
            $this->baseUri . $originUri,
            $body,
            $nonce
        );
        return $this->httpService->deleteMessage(
            $originUri,
            $body,
            $nonce,
            $checksum
        );
    }
}