<?php

namespace Database\Seeders;

use App\Services\TwitchService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

    protected TwitchService $twitchService;

    public function __construct(TwitchService $twitchService)
    {
        $this->twitchService = $twitchService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cursor = '';
        $tags   = [];

        do {
            $twitchTags  = $this->twitchService->getStreamTags($cursor);

            foreach ($twitchTags['data'] as $tag) {
                $tags[] = [
                    'id'          => $tag['tag_id'],
                    'name'        => $tag['localization_names']['en-us'],
                    'description' => $tag['localization_descriptions']['en-us'],
                    'created_at'  => now(),
                    'updated_at'  => now()
                ];
            }

            $cursor = $twitchTags['pagination'] ? $twitchTags['pagination']['cursor'] : '';
        } while ($twitchTags['pagination']);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        DB::table('tags')->truncate();
        DB::table('tags')->insert($tags);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
