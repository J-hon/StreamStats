<?php

namespace Tests;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected string $baseUrl = 'api';

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();

        $this->artisan('migrate:refresh');

        $this->withoutExceptionHandling();
    }
}
