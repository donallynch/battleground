<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;

/**
 * Class ApiService
 * @package App\Services
 */
class ApiService {

    /** @var string|null $accessToken */
    private $accessToken = null;

    /** @var string|null $Data */
    private $Data = null;

    /** @var string|null $authEndpoint */
    private $authEndpoint = null;

    /** @var string|null $endpoint */
    private $endpoint = null;

    /** @var string $authEmail */
    private $authEmail;

    /** @var string $authPassword */
    private $authPassword;

    /** @var string|null $now */
    private $now = null;

    /** @var \GuzzleHttp\Client $client */
    private $client;

    /** @var string $filePostfix */
    private $filePostfix = 'api-.csv';

    const TOKEN_FILE_NAME = 'api-api-tokens.txt';

    /**
     * ApiService constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->authEndpoint = 'https://www.api.com/api/auth';
        $this->endpoint = 'https://www.api.com/api/path';
        $this->authPassword = '';
        $this->authEmail = '';
        $this->now = date('Y-m-d H:i:s');
    }

    /**
     * @return bool
     */
    public function retrieveDataFromApi()
    {
        try {
            /* Make asynchronous request */
            $request = new \GuzzleHttp\Psr7\Request('GET', $this->endpoint, [
                "Authorization" => "Bearer {$this->accessToken}",
                'debug' => false
            ]);
            $promise = $this->client->sendAsync($request)->then(function ($response) {

                /* Ensure expected response code */
                if ($response->getStatusCode() !== 200) {
                    exit("Exception thrown during retrieveDataFromApi for request: {$this->endpoint}");
                }

                /* On success */
                $this->Data = $response->getBody();
            });

            $promise->wait();
        } catch (\Exception $e) {
            /* Request Access token from auth server */
            $this->getAccessToken();

            /* Retry api */
            $this->retrieveDataFromApi();
        }

        return true;
    }

    /**
     * @return bool
     */
    public function getAccessToken()
    {
        try {
            $client = HttpClient::create();
            $response = $client->request('POST', $this->authEndpoint, [
                'body' => [
                    'email' => $this->authEmail,
                    'password' => $this->authPassword
                ]
            ]);

            $statusCode = $response->getStatusCode();

            /* Ensure expected response code */
            if ($statusCode !== 200) {
                exit("A");
            }

            /* Set bearer token from response */
            $this->accessToken = $response->getContent();
            $this->saveToken();

        } catch (Exception $e) {
            exit("B");
        }

        return true;
    }

    /**
     * Returns the last line in the specified file
     * @return string
     */
    public function getLastUsedToken()
    {
        $tokenFile = self::TOKEN_FILE_NAME;

        /* If token file doesn't exist; create it */
        if (!file_exists($tokenFile)) {
            file_put_contents($tokenFile, '');
        }

        /* Retrieve last line in file */
        $line = '';
        $f = fopen($tokenFile, 'r');
        $cursor = -1;
        fseek($f, $cursor, SEEK_END);
        $char = fgetc($f);

        /* Trim whitespace */
        while ($char === "\n" || $char === "\r") {
            fseek($f, --$cursor, SEEK_END);
            $char = fgetc($f);
        }

        /* Read entire last line */
        while ($char !== false && $char !== "\n" && $char !== "\r") {
            $line = $char . $line;
            fseek($f, --$cursor, SEEK_END);
            $char = fgetc($f);
        }

        return $line;
    }

    /**
     * @return bool
     */
    public function saveToken()
    {
        $tokenFile = self::TOKEN_FILE_NAME;
        if (!file_exists($tokenFile)) {
            file_put_contents($tokenFile, $this->accessToken);
        } else {
            file_put_contents($tokenFile, "\n".$this->accessToken, FILE_APPEND);
        }

        return true;
    }

    /**
     *
     * @return bool
     */
    public function storeDataInFile()
    {
        $file = "{$this->now}-{$this->filePostfix}";
        file_put_contents("{$file}", $this->data);

        return true;
    }

    /**
     * @return null|string
     */
    public function getData()
    {
        return $this->data;
    }
}

