<?php

use App\Http\Controllers\Api\{
    PermissionController,
    UserController
};

use App\Http\Controllers\Api\Auth\{
    AuthApiController
};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthApiController::class, 'me'])->name('me');
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');

    Route::apiResource('/permissions', PermissionController::class);

    Route::apiResource('/users', UserController::class);
});

Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth');

Route::get('/', fn () => response()->json(['message' => 'Hello World!']));