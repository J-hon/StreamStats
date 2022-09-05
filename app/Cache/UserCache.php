<?php

namespace App\Cache;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserCache
{

    const USER_CACHE_KEY = 'user:';
    const ONE_HOUR_IN_SECONDS = 60 * 60;

    public static function cacheKey(string $key, int $id): string
    {
        return $key.$id;
    }

    public static function user(int $id)
    {
        return Cache::remember(
            self::cacheKey(self::USER_CACHE_KEY, $id),
            self::ONE_HOUR_IN_SECONDS,
            function () use ($id) {
                return User::query()->find($id);
            }
        );
    }

}
