<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;

Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth:sanctum');
Route::post('/wishlist', [WishlistController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->middleware('auth:sanctum');
Route::delete('/wishlist', [WishlistController::class, 'clear'])->middleware('auth:sanctum');
