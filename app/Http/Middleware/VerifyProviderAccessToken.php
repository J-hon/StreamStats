<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VerifyProviderAccessToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessTokenVerification = $this->validateUserAccessToken();
        if (array_key_exists('status', $accessTokenVerification) && $accessTokenVerification['status'] === 401) {
            return redirect()->route('/');
        }

        return $next($request);
    }

    private function validateUserAccessToken()
    {
        $response = Http::withHeaders([
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.Auth::user()->provider_token,
            'Client-id'     => config('services.twitch.client_id')
        ])->get("https://id.twitch.tv/oauth2/validate");

        return json_decode($response, true);
    }
}
