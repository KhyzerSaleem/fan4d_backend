<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MsegatService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('MSEGAT_API_URL');
        $this->apiKey = env('MSEGAT_API_KEY');
    }

    public function sendSms($to, $message)
    {
        try {
            $client = new Client();
            $response =$client->post(env('MSEGAT_API_URL'), [
                'json' => [
                    'apiKey' => env('MSEGAT_API_KEY'),
                    'to' => $to,
                    'message' => $message,
                    'userSender'=> "auth-mseg"
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
// Handle error
            return ['error' => $e->getMessage()];
        }
    }
}
