<?php

use App\Http\Controllers\Api\{
    PermissionController,
    UserController
};

use App\Http\Controllers\Api\Auth\{
    AuthApiController
};

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me'])->name('me');
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
});

Route::apiResource('/permissions', PermissionController::class);

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::post('/auth', [AuthApiController::class, 'auth'])->name('auth');

Route::get('/', fn () => response()->json(['message' => 'Hello World!']));
