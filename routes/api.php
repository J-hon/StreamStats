<?php

use App\Http\Controllers\Api\StatsController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth')->group(function () {
    Route::prefix('logout')->group(function () {
        Route::get('', function () {
            Auth::logout();
        });
    });

    Route::prefix('dashboard/stats')->group(function () {
        Route::get('top-streams', [StatsController::class, 'topStreams']);
        Route::get('streams-by-start-time', [StatsController::class, 'streamsByStartTime']);
        Route::get('top-100-streams-by-viewer-count', [StatsController::class, 'top100StreamsByViewerCount']);

        Route::get('user-shared-tags-with-top-streams', [StatsController::class, 'sharedTags'])->name('shared.tags');
        Route::get('user-following-top-streams', [StatsController::class, 'topStreamsUserIsFollowing'])->name('top.streams.following');
        Route::get('user-viewer-count-difference', [StatsController::class, 'getViewerCountDifference']);
    });
});
