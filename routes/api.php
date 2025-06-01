<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UKMController;

Route::middleware('api')->group(function () {
    Route::get('/hello', function () {
        return response()->json(['message' => 'Hello from API!']);
    });

    // API routes for UKM profiles (GET only)
    Route::get('/ukms', [UKMController::class, 'index']);
    Route::post('/ukms', [UKMController::class, 'store']);
    Route::get('/ukms/{id}', [UKMController::class, 'show']);
    Route::put('/ukms/{id}', [UKMController::class, 'update']);
    Route::delete('/ukms/{id}', [UKMController::class, 'destroy']);


    // User routes
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    // Authentication routes
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
});