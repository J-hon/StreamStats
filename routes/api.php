<?php

use App\Http\Controllers\Api\LoginController;
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
    Route::get('callback', [LoginController::class, 'handleProviderCallback']);
});
