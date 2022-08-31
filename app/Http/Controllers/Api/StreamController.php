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
        $streams = $this->streamService->viewerCountDiff();
        return $this->responseJson(true, 200, 'Top streams retrieved!', compact('streams'));
    }

}
