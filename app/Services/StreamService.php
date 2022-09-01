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
        return DB::table('streams')
            ->select('game_name')
            ->whereNotNull(['game_id', 'game_name'])
            ->selectRaw("COUNT(*) AS stream_count")
            ->selectRaw("SUM(viewer_count) AS viewer_count_sum")
            ->selectRaw("round(AVG(viewer_count), 0) AS viewer_count_avg")
            ->groupBy('game_name')
            ->paginate(10)
            ->toArray();
    }

    public function getStreamsByStartTime(): array
    {
        return DB::table('streams')
            ->addSelect(DB::raw('DATE_FORMAT(started_at, "%Y-%m-%d %H") AS rounded_up_start_time'))
            ->selectRaw("COUNT(*) AS stream_count")
            ->selectRaw("SUM(viewer_count) AS viewer_count_sum")
            ->groupBy('rounded_up_start_time')
            ->paginate(10)
            ->toArray();
    }

    public function getTopStreamsByViewerCount(string $sort = 'desc'): array
    {
        return DB::table('streams')
            ->select('id', 'title', 'viewer_count')
            ->orderBy('viewer_count', $sort)
            ->take(100)
            ->paginate(10)
            ->toArray();
    }

    public function getTopStreamsUserIsFollowing(): array
    {
        $userFollowedStreams = $this->getUserFollowedStreams();
        $streams = DB::table('streams')->get(['id', 'title', 'game_id', 'game_name', 'viewer_count'])->toArray();

        $userFollowedStreams = array_map(function ($stream) {
            return [
                'id'           => (int) $stream['id'],
                'title'        => $stream['title'],
                'game_id'      => $stream['game_id'],
                'game_name'    => $stream['game_name'],
                'viewer_count' => $stream['viewer_count']
            ];
        }, $userFollowedStreams);

        return array_intersect_key($userFollowedStreams, $streams);
    }

    public function viewerCountDiff()
    {
        $streams = Stream::query()->get()->toArray();

        $lowestStreamViewerCount  = $this->calculateMinimumValuesByKeyInAssociativeArray($streams);
        $userFollowedStreamsCount = $this->calculateMinimumValuesByKeyInAssociativeArray($this->getUserFollowedStreams());

        $quantityDistanceToTop1000 = $lowestStreamViewerCount - $userFollowedStreamsCount;
        return max($quantityDistanceToTop1000, 0);
    }

    public function getSharedTags(): array
    {
        $tags                = [];
        $userFollowedStreams = collect($this->getUserFollowedStreams())->pluck('id');
        $streams             = Stream::query()->with('tags:id,name,description')->whereIn('id', $userFollowedStreams)->get();

        foreach ($streams as $stream) {
            foreach ($stream->tags as $tag) {
                $tags[] = [
                    'name'        => $tag->name,
                    'description' => $tag->description
                ];
            }
        }

        return $tags;
    }

    private function getUserFollowedStreams(): array
    {
        return $this->twitchApiService->getUserFollowedStreams(821326948)['data'];
    }

    private function calculateMinimumValuesByKeyInAssociativeArray(array $params, string $key = 'viewer_count'): int
    {
        return array_reduce($params, function($carry, $item) use ($key) {
            return min($carry, $item[$key]);
        }, PHP_INT_MAX);
    }

}
