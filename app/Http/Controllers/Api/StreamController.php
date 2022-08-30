<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\TwitchApiService;
use Illuminate\Http\JsonResponse;

class StreamController extends BaseController
{

    protected TwitchApiService $twitchApiService;

    public function __construct(TwitchApiService $twitchApiService)
    {
        $this->twitchApiService = $twitchApiService;
    }

    public function index(): JsonResponse
    {
        $streams = $this->twitchApiService->getStreams();
        return $this->responseJson(true, 200, 'Streams retrieved!', compact('streams'));
    }

}
