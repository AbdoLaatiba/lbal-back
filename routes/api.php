<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// auth routes
require __DIR__ . '/api/auth.php';

// media routes
require __DIR__ . '/api/media.php';

// product routes
require __DIR__ . '/api/products.php';
