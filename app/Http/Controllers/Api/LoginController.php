<?php

namespace App\Http\Controllers\Api;

use App\Cache\ProviderTokenCache;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends BaseController
{

    public function redirectToProvider(string $provider): JsonResponse
    {
        $redirectUrl = Socialite::driver($provider)->scopes(['user:read:follows'])->stateless()->redirect()->getTargetUrl();
        return $this->responseJson(true, 200, 'Redirect URL retrieved!', ['redirect_url' => $redirectUrl]);
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $this->updateOrCreateAndLoginUser($user);

        return redirect()->route('console.dashboard');
    }

    private function updateOrCreateAndLoginUser(object $data): void
    {
        $user = User::query()->updateOrCreate([
            'provider_id'    => $data->id
        ], [
            'username'       => $data->name,
            'provider_token' => $data->token,
            'email'          => $data->email
        ]);

        Auth::login($user);

        ProviderTokenCache::cache($data->token);
    }

}
