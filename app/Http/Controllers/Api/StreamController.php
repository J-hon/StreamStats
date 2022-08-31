<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\StreamService;
use Illuminate\Http\JsonResponse;

class StreamController extends BaseController
{

    protected StreamService $streamService;

    public function __construct(StreamService $streamService)
    {
        $this->streamService = $streamService;
    }

    public function index(): JsonResponse
    {
        $stats = $this->streamService->getStats();
        return $this->responseJson(true, 200, 'Stats retrieved!', compact('stats'));
    }

}
