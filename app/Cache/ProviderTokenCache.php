<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

class ProviderTokenCache
{

    const PROVIDER_CACHE_KEY  = 'provider_token';
    const ONE_HOUR_IN_SECONDS = 60 * 60;

    public static function cache(string $providerToken): bool
    {
        return Cache::put(self::PROVIDER_CACHE_KEY, $providerToken, self::ONE_HOUR_IN_SECONDS);
    }

    public static function get(): string|null
    {
        return Cache::get(self::PROVIDER_CACHE_KEY);
    }

}
