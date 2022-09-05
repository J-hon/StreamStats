<?php

namespace Tests;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected string $baseUrl = 'api';

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();

        Artisan::call('migrate:fresh');

        $this->withoutExceptionHandling();
    }
}
