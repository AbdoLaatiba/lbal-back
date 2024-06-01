<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


// Register routes for user authentication
Route::group(['prefix' => 'auth'], function () {
    // Login route
    Route::post('login', [AuthController::class, 'login']);

    // Register route
    Route::post('register', [AuthController::class, 'register']);

    // Logout route
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // register admin route
    Route::post('register-admin', [AuthController::class, 'registerAdmin'])->middleware(['auth:sanctum', 'check_admin']);
});

