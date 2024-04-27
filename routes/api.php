<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('posts', PostController::class)
    ->only('store', 'update', 'destroy')
    ->middleware('auth:sanctum');
Route::resource('posts', PostController::class)
    ->only('index', 'show');
