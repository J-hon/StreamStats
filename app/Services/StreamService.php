<?php

namespace App\Services;

use App\Cache\StreamCache;
use App\Models\Stream;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StreamService
{

    protected TwitchService $twitchService;

    public function __construct(TwitchService $twitchService)
    {
        $this->twitchService = $twitchService;
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
        $streams = StreamCache::get();
        $userFollowedStreams = $this->getUserFollowedStreams();

        $userFollowedStreams = array_map(function ($stream) {
            return [
                'id'           => (int) $stream['id'],
                'title'        => $stream['title'],
                'game_id'      => $stream['game_id'],
                'game_name'    => $stream['game_name'],
                'viewer_count' => $stream['viewer_count']
            ];
        }, $userFollowedStreams);

        $streams = array_intersect_key($userFollowedStreams, $streams);
        return $this->paginate($streams, options: [
            'path' => route('top.streams.following')
        ])->toArray();
    }

    public function viewerCountDiff()
    {
        $streams = StreamCache::get();

        $lowestStreamViewerCount  = $this->calculateMinimumValuesByKeyInAssociativeArray($streams);
        $userFollowedStreamsCount = $this->calculateMinimumValuesByKeyInAssociativeArray($this->getUserFollowedStreams());

        $quantityDistanceToTop1000 = $lowestStreamViewerCount - $userFollowedStreamsCount;
        return max($quantityDistanceToTop1000, 0);
    }

    public function getSharedTags(): array
    {
        $tags                = [];
        $userFollowedStreams = collect($this->getUserFollowedStreams())->pluck('id')->unique('id')->toArray();
        $streams             = Stream::query()->with('tags:id,name,description')->whereIn('id', $userFollowedStreams)->get();

        foreach ($streams as $stream) {
            foreach ($stream->tags as $tag) {
                $tags[] = [
                    'name'        => $tag->name,
                    'description' => $tag->description
                ];
            }
        }

        return $this->paginate($tags, options: [
            'path' => route('shared.tags')
        ])->toArray();
    }

    private function getUserFollowedStreams(): array
    {
        return $this->twitchService->getUserFollowedStreams(Auth::user()->provider_id)['data'];
    }

    private function calculateMinimumValuesByKeyInAssociativeArray(array $params, string $key = 'viewer_count'): int
    {
        return array_reduce($params, function($carry, $item) use ($key) {
            return min($carry, $item[$key]);
        }, PHP_INT_MAX);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
