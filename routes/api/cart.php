<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->middleware('auth:sanctum');
Route::post('/cart', [CartController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->middleware('auth:sanctum');
Route::delete('/cart/clear', [CartController::class, 'clear'])->middleware('auth:sanctum');
