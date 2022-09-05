<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

class LoginTest extends TestCase
{

    public function test_redirect_to_provider()
    {
        $provider = 'twitch';
        $this->getJson("auth/$provider/redirect")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'redirect_url'
                ]
            ]);
    }

    public function test_handle_provider_callback()
    {
        $provider = 'twitch';
        $this->mockSocialite("$provider", [
            'id' => 1,
            'name' => 'test_user',
            'email' => 'test@example.com',
            'token' => 'access-token'
        ]);

        $this->get("auth/$provider/callback")->assertRedirect();

        $this->assertDatabaseHas('users', [
            'provider_token' => 'access-token'
        ]);
    }

    protected function mockSocialite(string $provider, $user = null)
    {
        $mock = Socialite::shouldReceive('stateless')
            ->andReturn(Mockery::self())
            ->shouldReceive('driver')
            ->with($provider)
            ->andReturn(Mockery::self());

        if ($user) {
            $mock->shouldReceive('user')
                ->andReturn((new SocialiteUser)->setRaw($user)->map($user));
        } else {
            $mock->shouldReceive('redirect')
                ->andReturn(redirect('https://url-to-provider'));
        }
    }
}
