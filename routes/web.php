<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::view('/', 'login')->name('login');
});

Route::prefix('auth/{provider}')->group(function () {
    Route::get('redirect', [LoginController::class, 'redirectToProvider']);
    Route::get('callback', [LoginController::class, 'handleProviderCallback']);
});

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('console.dashboard');
});
