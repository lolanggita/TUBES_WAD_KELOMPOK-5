<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::middleware('api')->get('/hello', function () {
    return response()->json(['message' => 'Hello from API!']);
});

Route::apiResource('users', UserController::class)->only(['index', 'show']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);