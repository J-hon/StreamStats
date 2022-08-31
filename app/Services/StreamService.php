<?php

namespace App\Services;

use App\Models\Stream;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StreamService
{

    protected TwitchApiService $twitchApiService;

    public function __construct(TwitchApiService $twitchApiService)
    {
        $this->twitchApiService = $twitchApiService;
    }

    public function getTopStreams(): array
    {
        return Stream::query()
            ->select('game_name')
            ->selectRaw("COUNT(game_name) as stream_count")
            ->selectRaw("SUM(viewer_count) as viewer_count_sum")
            ->selectRaw("round(AVG(viewer_count), 0) as viewer_count_avg")
            ->groupBy('game_name')
            ->get()
            ->toArray();
    }

    public function getTopStreamsByStartTime(): array
    {
        return Stream::query()
            ->selectRaw("game_name")
            ->addSelect(DB::raw('DATE_FORMAT(started_at, "%Y-%m-%d %H") as started_at, COUNT(game_name) as stream_count'))
            ->get()
            ->groupBy('started_at')
            ->toArray();
    }

    public function getTop100StreamsByViewerCount()
    {
        return Stream::query()
            ->select('id', 'title', 'game_name', 'viewer_count', 'started_at')
            ->orderBy('viewer_count', 'desc')
            ->limit(100)
            ->get();
    }

    public function getTopStreamsUserIsFollowing()
    {
        $userFollowedStreams = $this->twitchApiService->getUserFollowedStreams(Auth::user()->provider_id)['data'];
        $streams = Stream::query()->get(['id', 'title', 'game_id', 'game_name', 'viewer_count'])->toArray();

        $userFollowedStreams = array_map(function ($stream) {
            return [
                'id' => (int) $stream['id'],
                'title' => $stream['title'],
                'game_id' => $stream['game_id'],
                'game_name' => $stream['game_name'],
                'viewer_count' => $stream['viewer_count']
            ];
        }, $userFollowedStreams);

        return array_intersect_key($userFollowedStreams, $streams);
    }

    public function viewerCountDiff()
    {
        $userFollowedStreams     = $this->twitchApiService->getUserFollowedStreams(Auth::user()->provider_id)['data'];
        $lowestStreamViewerCount = Stream::query()->get()->toArray();

        $lowestStreamViewerCount = array_reduce($lowestStreamViewerCount, function($min, $details) {
            return min($min, $details['viewer_count']);
        }, PHP_INT_MAX);

        $min = array_reduce($userFollowedStreams, function($min, $details) {
            return min($min, $details['viewer_count']);
        }, PHP_INT_MAX);

        $quantityDistanceToTop1000 = $lowestStreamViewerCount - $min;
        return $quantityDistanceToTop1000 < 0 ? 0 : $quantityDistanceToTop1000;
    }

}
