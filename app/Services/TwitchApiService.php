<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TwitchApiService
{

    private string $baseUrl;
    protected PendingRequest $httpClient;

    public function __construct()
    {
        $this->baseUrl    = 'https://api.twitch.tv/helix';
        $this->httpClient = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer l3jrw3wzo8mgykgk9r5zx8qhp9p6qk',
            'Client-id'     => config('services.twitch.client_id')
        ]);
    }

    public function getStreams(string $cursor = ''): array
    {
        $response = $this->httpClient->get($this->baseUrl . '/streams?first=100&after='.$cursor);
        return json_decode($response, true);
    }

}
