<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth/{provider}')->group(function () {
    Route::get('redirect', [LoginController::class, 'redirectToProvider']);
});

Route::prefix('dashboard/stats')->group(function () {
    Route::get('top-streams', [StatsController::class, 'topStreams']);
    Route::get('streams-by-start-time', [StatsController::class, 'streamsByStartTime']);
    Route::get('top-100-streams-by-viewer-count', [StatsController::class, 'top100StreamsByViewerCount']);

    Route::get('user-shared-tags-with-top-streams', [StatsController::class, 'sharedTags']);
    Route::get('user-followed-top-streams', [StatsController::class, 'topStreamsUserIsFollowing']);
    Route::get('user-viewer-count-difference', [StatsController::class, 'getViewerCountDifference']);
});
