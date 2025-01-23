<?php

namespace EmurgoLabs\TgeSdk;
use GuzzleHttp\Client;

class UserService
{
    private $client;
    private $apiKey;
    private $apiSecret;
    private $baseUri;
    private $httpService;

    public function __construct($baseUri, $apiKey, $apiSecret)
    {
        $this->apiKey = $_ENV["SDK_TGE_API_KEY"];
        $this->apiSecret = $_ENV["SDK_TGE_SECRET_KEY"];
        $this->baseUri = $_ENV["SDK_TGE_API_BASE_URI"];
        $this->httpService = new HttpService();
    }

    /* 
     * Get all user from the API
     * @return object
     */
    public function signMessage($address)
    {
        return $this->httpService->getMessage("/user/sign-message/" . $address);
    }

    /* 
     * Get a user from the API
     * @return object
     */
    public function getProfile()
    {
        return $this->httpService->getMessage("/user/profile");
    }

    /* 
     * Get all user from the API
     * @return object
     */
    public function getAll()
    {
        return $this->httpService->getMessage("/user/all");
    }

    /*
     * Verify signation
     * @param string $address
     * @param string $signature
     * @return object
     */
    public function verifySignation($address, $signature)
    {
        $originUri = "/user/check/old-password";
        $nonce = time();
        $body = ['address' => $address, 'signature' => $signature];
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
     * Signup
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $walletAddress
     * @return object
     */
    public function signup(
        $username,
        $password,
        $firstName,
        $lastName,
        $email,
        $walletAddress
    ) {
        $originUri = "/user/signup";
        $nonce = time();
        $body = [
            'username' => $username,
            'password' => $password,
            'firstName'
            => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'walletAddress' => $walletAddress
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
     * Signup OTP
     * @param string $username
     * @param string $password
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $walletAddress
     * @return object
     */
    public function signupOtp(
        $username,
        $password,
        $firstName,
        $lastName,
        $email,
        $walletAddress
    ) {
        $originUri = "/user/signup-otp";
        $nonce = time();
        $body = [
            'username' => $username,
            'password' => $password,
            'firstName' =>
                $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'walletAddress' => $walletAddress
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
     * Confirm OTP
     * @param string $email
     * @param string $otp
     * @return object
     */
    public function confirmOtp($email, $otp)
    {
        $originUri = "/user/confirm-otp";
        $nonce = time();
        $body = ['email' => $email, 'otp' => $otp];
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
     * Signin
     * @param string $username
     * @param string $password
     * @return object
     */
    public function signin($username, $password)
    {
        $originUri = "/user/signin";
        $nonce = time();
        $body = ['username' => $username, 'password' => $password];
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
     * Signin with email
     * @param string $email
     * @param string $password
     * @return object
     */
    public function signWithEmail($email, $password)
    {
        $originUri = "/user/signin/email";
        $nonce = time();
        $body = ['email' => $email, 'password' => $password];
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
     * Forgot password
     * @param string $email
     * @return object
     */
    public function forgotPassword($email)
    {
        $originUri = "/user/forgot-password";
        $nonce = time();
        $body = ['email' => $email];
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
     * Change password
     * @param string $token
     * @param string $password
     * @return object
     */
    public function changePassword($token, $password)
    {
        $originUri = "/user/change-password";
        $nonce = time();
        $body = ['token' => $token, 'password' => $password];
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
     * Check username
     * @param string $username
     * @return object
     */
    public function checkUsername($username)
    {
        $originUri = "/user/check/username";
        $nonce = time();
        $body = ['username' => $username];
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
     * Check email
     * @param string $email
     * @return object
     */
    public function checkEmail($email)
    {
        $originUri = "/user/check/email";
        $nonce = time();
        $body = ['email' => $email];
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
     * Check old password
     * @param string $username
     * @param string $password
     * @return object
     */
    public function checkOldPassword($username, $password)
    {
        $originUri = "/user/check/old-password";
        $nonce = time();
        $body = ['username' => $username, 'password' => $password];
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