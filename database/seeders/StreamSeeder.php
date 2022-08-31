<?php

namespace Database\Seeders;

use App\Cache\StreamCache;
use App\Services\TwitchApiService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StreamSeeder extends Seeder
{
    protected TwitchApiService $twitchApiService;

    public function __construct(TwitchApiService $twitchApiService)
    {
        $this->twitchApiService = $twitchApiService;
    }

    public function run(): void
    {
        $cursor         = '';
        $topLiveStreams = [];
        $streamTags     = [];

        for ($i = 0; $i < 10; $i++) {
            $streams = $this->twitchApiService->getStreams($cursor);

            foreach($streams['data'] as $stream) {
                $topLiveStreams[] = [
                    'id'           => $stream['id'],
                    'title'        => $stream['title'],
                    'game_id'      => $stream['game_id'],
                    'game_name'    => $stream['game_name'],
                    'viewer_count' => $stream['viewer_count'],
                    'started_at'   => Carbon::parse($stream['started_at'])->toDateTimeString(),
                    'created_at'   => now(),
                    'updated_at'   => now()
                ];

                foreach ($stream['tag_ids'] ?? [] as $tagId) {
                    $streamTags[] = [
                        'tag_id'     => $tagId,
                        'stream_id'  => $stream['id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            $cursor = $streams['pagination']['cursor'];
        }

        $topLiveStreams = collect($topLiveStreams)->unique('id')->shuffle()->toArray();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('streams')->truncate();
        DB::table('stream_tag')->truncate();

        DB::table('streams')->insert($topLiveStreams);
        DB::table('stream_tag')->insert($streamTags);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        StreamCache::cacheTop1000Streams();
    }
}
