<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::put('/products/{product}/archive', [ProductController::class, 'archive'])->middleware('auth:sanctum');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum', 'check_admin']);
Route::put('/products/{product}/approve', [ProductController::class, 'approve'])->middleware(['auth:sanctum', 'check_admin']);
Route::put('/products/{product}/disapprove', [ProductController::class, 'disapprove'])->middleware(['auth:sanctum', 'check_admin']);
