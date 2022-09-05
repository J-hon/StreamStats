<?php

namespace App\Http\Middleware;

use App\Services\TwitchService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyProviderAccessToken
{
    protected TwitchService $twitchService;

    public function __construct(TwitchService $twitchService)
    {
        $this->twitchService = $twitchService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessTokenVerification = $this->twitchService->validateUserAccessToken(Auth::user()->provider_token);
        if (array_key_exists('status', $accessTokenVerification) && $accessTokenVerification['status'] === 401) {
            return redirect()->route('/');
        }

        return $next($request);
    }
}
