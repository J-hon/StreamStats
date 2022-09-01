<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
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
            'Authorization' => 'Bearer 6ts774kee7krf5eq3s32v28qlmutnu',
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

    protected function returnAssocResponse(Response $response)
    {
        return json_decode($response, true);
    }

}
