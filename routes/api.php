<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/hello', function () {
    return response()->json(['message' => 'Hello from API!']);
});

// API routes for UKM profiles (GET only)
Route::get('/ukms', [UKMController::class, 'indexApi']);
Route::get('/ukms/{ukm}', [UKMController::class, 'showApi']);