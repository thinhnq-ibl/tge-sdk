<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class ProjectService
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
     * Get a project mint from the API
     * @param string $id
     * @return object
     */
    public function getProjectMint($id)
    {
        return $this->httpService->getMessage("/project/mint/" . $id);
    }

    /* 
     * Get all project mint from the API
     * @param string $userId
     * @param string $toAddress
     * @param string $name
     * @param string $symbol
     * @return object
     */
    public function getAllProjectMint(
        $userId,
        $toAddress,
        $name,
        $symbol
    ) {
        $data = array(
            'userId' => $userId,
            'toAddress' => $toAddress,
            'name' => $name,
            'symbol' => $symbol
        );

        $query = http_build_query($data);
        return $this->httpService->getMessage("/project/mint/all?" . $query);
    }

    /* 
     * Get all project from the API
     * @param string $userId
     * @param string $toAddress
     * @param string $name
     * @param string $symbol
     * @return object
     */
    public function getAllProject(
        $userId,
        $toAddress,
        $name,
        $symbol
    ) {
        $data = array(
            'userId' => $userId,
            'toAddress' => $toAddress,
            'name' => $name,
            'symbol' => $symbol
        );

        $query = http_build_query($data);
        return $this->httpService->getMessage("/project/all?" . $query);
    }

    /* 
     * Get a project from the API
     * @param string $id
     * @return object
     */
    public function getProject($id)
    {
        return $this->httpService->getMessage("/project/" . $id);
    }

    /* 
     * Get a project credit from the API
     * @param string $id
     * @param string $address
     * @return object
     */
    public function getProjectCreditById($id, $address)
    {
        return $this->httpService->getMessage("/project/credit/" . $address . "/" . $id);
    }

    /* 
     * Get a project credit from the API
     * @param string $address
     * @return object
     */
    public function getProjectCredit($address)
    {
        return $this->httpService->getMessage("/project/credit/" . $address);
    }

    /* 
     * Create a project mint from the API
     * @param string $userId
     * @param string $toAddress
     * @param string $boundary
     * @param string $initialPlantedTree
     * @param string $currentPlantedTree
     * @param string $maxPlantedTree
     * @param string $ratio
     * @param string $carbonCredit
     * @param string $name
     * @param string $symbol
     * @return object
     */
    public function createProjectMint(
        $userId,
        $toAddress,
        $boundary,
        $initialPlantedTree,
        $currentPlantedTree,
        $maxPlantedTree,
        $ratio,
        $carbonCredit,
        $name,
        $symbol
    ) {
        $originUri = "/project/mint";
        $nonce = time();
        $body = [
            'userId' => $userId,
            'toAddress' => $toAddress,
            'boundary' => $boundary,
            'initialPlantedTree' => $initialPlantedTree,
            'currentPlantedTree' => $currentPlantedTree,
            'maxPlantedTree' => $maxPlantedTree,
            'ratio' => $ratio,
            'carbonCredit' => $carbonCredit,
            'name' => $name,
            'symbol' => $symbol
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
     * Create a project from the API
     * @param string $userId
     * @param string $toAddress
     * @param string $boundary
     * @param string $initialPlantedTree
     * @param string $currentPlantedTree
     * @param string $maxPlantedTree
     * @param string $ratio
     * @param string $carbonCredit
     * @param string $name
     * @param string $symbol
     * @return object
     */
    public function createAudit(
        $id,
        $userId,
        $currentPlantedTree,
        $carbonCredit
    ) {
        $originUri = "/project/audit/" . $id;
        $nonce = time();
        $body = [
            "userId" => $userId,
            "currentPlantedTree" => $currentPlantedTree,
            "carbonCredit" => $carbonCredit
        ];
        $checksum = $this->httpService->createCheckSum(
            $this->apiSecret,
            "POST",
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
     * Update a project mint from the API
     * @param string $id
     * @param string $currentPlantedTree
     * @param string $carbonCredit
     * @param string $isMinted
     * @param string $isAudited
     * @return object
     */
    public function updateMint(
        $id,
        $currentPlantedTree,
        $carbonCredit,
        $isMinted,
        $isAudited
    ) {
        $originUri = "/project/update/" . $id;
        $nonce = time();
        $body = [
            "currentPlantedTree" => $currentPlantedTree,
            "carbonCredit" => $carbonCredit,
            "isMinted" => $isMinted,
            "isAudited" => $isAudited
        ];
        $checksum = $this->httpService->createCheckSum(
            $this->apiSecret,
            "PATCH",
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
}