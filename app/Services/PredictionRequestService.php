<?php

namespace App\Services;

use GuzzleHttp\Client;

class PredictionRequestService {
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $urls;

    function __construct (Client $client)
    {
        $this->client = $client;
        $this->urls['base'] = env('PYTHON_APP_URL');
        $this->urls['heart'] = $this->urls['base'] . '/predict/heart';
        $this->urls['diabetes'] = $this->urls['base'] . '/predict/diabetes';
    }

    public function predictHeartDisease(array $data)
    {
        $response = $this->client->post($this->urls['heart'], ['form_params' => $data]);
        return json_decode($response->getBody(), true);
    }
}