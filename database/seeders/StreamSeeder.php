<?php

namespace Database\Seeders;

use App\Services\TwitchService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StreamSeeder extends Seeder
{
    protected TwitchService $twitchService;

    public function __construct(TwitchService $twitchService)
    {
        $this->twitchService = $twitchService;
    }

    public function run(): void
    {
        $cursor         = '';
        $topLiveStreams = [];
        $streamTags     = [];

        do {
            $streams = $this->twitchService->getStreams($cursor);

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

        } while (count($topLiveStreams) <= 900);

        $topLiveStreams = collect($topLiveStreams)->unique('id')->shuffle()->toArray();

        Schema::disableForeignKeyConstraints();

        DB::table('stream_tag')->truncate();
        DB::table('streams')->truncate();

        DB::table('streams')->insert($topLiveStreams);
        DB::table('stream_tag')->insert($streamTags);

        Schema::enableForeignKeyConstraints();
    }
}
