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
    Route::post('logout', [AuthController::class, 'logout']);

    // register admin route
    Route::post('register-admin', [AuthController::class, 'registerAdmin']);

    // Password reset routes
    // Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    // Route::post('password/reset', 'ResetPasswordController@reset');
});

// Protected routes that require authentication
Route::group(['middleware' => 'auth:api'], function () {
    // User profile route
    Route::get('profile', [UserController::class, 'profile']);
});
