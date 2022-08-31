<?php

namespace Database\Seeders;

use App\Services\TwitchApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{

    protected TwitchApiService $twitchApiService;

    public function __construct(TwitchApiService $twitchApiService)
    {
        $this->twitchApiService = $twitchApiService;
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
            $twitchTags  = $this->twitchApiService->getStreamTags($cursor);

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
