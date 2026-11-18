<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SavedDoctorController;
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
        // doctors
        Route::get('doctors', [DoctorController::class, 'index']);
        Route::get('doctors/{id}', [DoctorController::class, 'show']);
        Route::post('doctors', [DoctorController::class, 'store']); //admin

        // appointment
        Route::post('appointments', [AppointmentController::class, 'store']);
        Route::get('appointments', [AppointmentController::class, 'index']);

        // saved doctors
        Route::post('saved-doctors', [SavedDoctorController::class, 'store']);
        Route::get('saved-doctors', [AppointmentController::class, 'index']);
        Route::delete('saved-doctors/{id}', [AppointmentController::class, 'destroy']);
    });
});
