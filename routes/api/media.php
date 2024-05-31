<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

Route::post('media', [MediaController::class, 'store']);
Route::delete('media/{id}', [MediaController::class, 'destroy']);
Route::delete('media', [MediaController::class, 'destroyAll']);
Route::get('media', [MediaController::class, 'index']);
Route::get('media/{id}', [MediaController::class, 'show']);
Route::get('media/{id}/download', [MediaController::class, 'download']);
