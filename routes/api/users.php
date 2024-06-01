<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('profile', [UserController::class, 'profile'])->middleware('auth:sanctum');
Route::put('profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

Route::put('update-account-status', [UserController::class, 'updateAccountStatus'])->middleware('auth:sanctum', 'check_admin');
