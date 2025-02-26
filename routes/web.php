<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('login')->group(function () {
    Route::get('', [AuthController::class, 'redirectToProvider'])->name('login');
});
Route::get('logout', function () {
    Auth::logout();

    return redirect()->route('login');
})->name('logout');

Route::prefix('auth/{provider}')->group(function () {
    Route::get('redirect', [AuthController::class, 'redirectToProvider']);
    Route::get('callback', [AuthController::class, 'handleProviderCallback']);
});

Route::get('/', function () {
    return view('home');
});
