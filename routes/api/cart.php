<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->middleware('auth:sanctum');
Route::post('/cart', [CartController::class, 'addToCart'])->middleware('auth:sanctum');
Route::delete('/cart', [CartController::class, 'removeFromCart'])->middleware('auth:sanctum');
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->middleware('auth:sanctum');
