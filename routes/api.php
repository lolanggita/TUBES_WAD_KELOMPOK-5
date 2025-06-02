<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UKMController;
use App\Http\Controllers\Api\GalleryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group.
|
*/

// Test route (opsional)
Route::get('/hello', function () {
    return response()->json(['message' => 'Hello from Laravel API!']);
});

// Authentication
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

// Protected Routes (Harus login via Sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // User API
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    // Gallery API
    Route::apiResource('galleries', GalleryController::class);

    // UKM API
    Route::apiResource('ukms', UKMController::class);

    // Optional: Cek user yang sedang login
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    });
});