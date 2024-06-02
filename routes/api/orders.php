<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::post('orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::put('orders/{order}', [OrderController::class, 'update'])->middleware(['auth:sanctum', 'check_admin']);
Route::delete('orders/{order}', [OrderController::class, 'destroy'])->middleware('auth:sanctum');
