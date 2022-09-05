<?php

namespace App\Cache;

use App\Models\Stream;
use Illuminate\Support\Facades\Cache;

class StreamCache
{

    const USER_CACHE_KEY = 'top_streams';
    const FIFTEEN_MINUTES_IN_SECONDS = 15 * 60;

    public static function get()
    {
        return Cache::remember(
            self::USER_CACHE_KEY,
            self::FIFTEEN_MINUTES_IN_SECONDS,
            function () {
                return Stream::query()->select(['id', 'title', 'game_id', 'game_name', 'viewer_count'])->get()->toArray();
            }
        );
    }

}
