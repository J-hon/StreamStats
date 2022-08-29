<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends BaseController
{

    public function redirectToProvider(string $provider): JsonResponse
    {
        $redirectUrl = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
        return $this->responseJson(true, 200, 'Redirect URL retrieved!', ['redirect_url' => $redirectUrl]);
    }

    public function handleProviderCallback(string $provider): View
    {
        $user     = Socialite::driver($provider)->stateless()->user();
        $response = $this->createOrLoginUser($user);

        return view('dashboard', ['response' => $response]);
    }

    private function createOrLoginUser(object $data): array
    {
        $userQuery = User::query();

        $user = $userQuery->updateOrCreate([
            'provider_id'    => $data->id,
        ], [
            'username'       => $data->name,
            'provider_token' => $data->token,
            'email'          => $data->email
        ]);

        return [
            'user'       => new UserResource($user),
            'auth_token' => $user->createToken(config('app.name'))->plainTextToken
        ];
    }

}
