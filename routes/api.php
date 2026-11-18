<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('medicgo-api/v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {
        //
    });
});
