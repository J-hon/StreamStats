<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Services\StreamService;
use Illuminate\Http\JsonResponse;

class StatsController extends BaseController
{

    protected StreamService $streamService;

    public function __construct(StreamService $streamService)
    {
        $this->streamService = $streamService;
    }

    public function topStreams(): JsonResponse
    {
        $topStreams = $this->streamService->getTopStreams();
        return $this->responseJson(true, 200, 'Success!', $topStreams);
    }

    public function top100StreamsByViewerCount(): JsonResponse
    {
        $topStreams = $this->streamService->getTopStreamsByViewerCount(request('sort'));
        return $this->responseJson(true, 200, 'Success!', $topStreams);
    }

    public function streamsByStartTime(): JsonResponse
    {
        $topStreams = $this->streamService->getStreamsByStartTime();
        return $this->responseJson(true, 200, 'Success!', $topStreams);
    }

    public function topStreamsUserIsFollowing(): JsonResponse
    {
        $topStreams = $this->streamService->getTopStreamsUserIsFollowing();
        return $this->responseJson(true, 200, 'Success!', $topStreams);
    }

    public function sharedTags(): JsonResponse
    {
        $tags = $this->streamService->getSharedTags();
        return $this->responseJson(true, 200, 'Success!', $tags);
    }

    public function getViewerCountDifference(): JsonResponse
    {
        $tags = $this->streamService->viewerCountDiff();
        return $this->responseJson(true, 200, 'Success!', $tags);
    }

}
