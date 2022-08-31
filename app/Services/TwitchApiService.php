<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class TwitchApiService extends BaseService
{

    private string $baseUrl;
    protected PendingRequest $httpClient;

    public function __construct()
    {
        $this->baseUrl    = 'https://api.twitch.tv/helix';
        $this->httpClient = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer 9ut64vho1pemhf64rzwy5psla8cy83',
            'Client-id'     => config('services.twitch.client_id')
        ]);
    }

    public function getStreams(string $cursor = ''): array
    {
        $response = $this->httpClient->get("$this->baseUrl/streams?first=100&after=$cursor");
        return $this->returnAssocResponse($response);
    }

    public function getUserFollowedStreams(int $userId, string $cursor = ''): array
    {
        $response = $this->httpClient->get("$this->baseUrl/streams/followed?user_id=$userId&first=100&after=$cursor");
        return $this->returnAssocResponse($response);
    }

    public function getStreamTags(string $cursor = ''): array
    {
        $response = $this->httpClient->get("$this->baseUrl/tags/streams?first=100&after=$cursor");
        return $this->returnAssocResponse($response);
    }

}
