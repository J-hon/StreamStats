<?php

namespace Tests\Unit;

use App\Cache\ProviderTokenCache;
use Tests\TestCase;

class RefreshStreamCommandTest extends TestCase
{
    public function test_refresh_stream_command_runs()
    {
        // set provider token to make test pass
        ProviderTokenCache::cache('oauth token');

        $this->artisan('stream:refresh');
        $this->assertDatabaseCount('streams', 1000);
    }
}
