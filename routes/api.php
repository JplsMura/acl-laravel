<?php

use App\Http\Controllers\Api\{
    PermissionController,
    PermissionUserController,
    UserController
};

use App\Http\Controllers\Api\Auth\{
    AuthApiController
};

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/permissions', PermissionController::class);

    Route::post('users/{user}/permission-sync', [PermissionUserController::class, 'syncPermissionOfUser'])->name('user.permission.sync');
    
    Route::apiResource('/users', UserController::class);

    Route::get('/me', [AuthApiController::class, 'me'])->name('me');
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
});

Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth');

Route::get('/', fn () => response()->json(['message' => 'Hello World!']));