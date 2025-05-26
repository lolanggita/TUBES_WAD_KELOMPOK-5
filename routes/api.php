<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->get('/hello', function () {
    return response()->json(['message' => 'Hello from API!']);
});