<?php

namespace App\Cache;

use App\Models\Stream;
use Illuminate\Support\Facades\Cache;

class StreamCache
{

    const CACHE_KEY               = 'top_1000_streams';
    const FIFTEEN_MINS_IN_SECONDS = 15 * 60;

    public static function cacheTop1000Streams(): mixed
    {
        return Cache::remember(self::CACHE_KEY, self::FIFTEEN_MINS_IN_SECONDS, function () {
            return Stream::query()->get()->toArray();
        });
    }

    public static function invalidate(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

}
