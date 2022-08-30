<?php

namespace Database\Seeders;

use App\Services\TwitchApiService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StreamSeeder extends Seeder
{
    protected TwitchApiService $twitchApiService;

    public function __construct(TwitchApiService $twitchApiService)
    {
        $this->twitchApiService = $twitchApiService;
    }

    public function run(): void
    {
        $topLiveStreams = [];
        $cursor         = '';

        for ($i = 0; $i < 10; $i++) {
            $streams = $this->twitchApiService->getStreams($cursor);

            foreach($streams['data'] as $stream) {
                $topLiveStreams[] = [
                    'title'        => $stream['title'],
                    'game_id'      => $stream['game_id'],
                    'game_name'    => $stream['game_name'],
                    'viewer_count' => $stream['viewer_count'],
                    'started_at'   => Carbon::parse($stream['started_at'])->toDateTimeString(),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            $cursor = $streams['pagination']['cursor'];
        }

        DB::table('streams')->truncate();
        DB::table('streams')->insert($topLiveStreams);
    }
}
