<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UKMController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Administrator
Route::middleware(['auth', 'role:administrator'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::post('/admin/post-event', [EventController::class, 'store']);
    Route::get('/admin/manage-reports', [ReportController::class, 'index']);
    Route::post('/admin/verify-ukm', [UKMController::class, 'verify']);
    Route::post('/admin/post-event', [EventController::class, 'store']);
    Route::post('/admin/manage-comments', [CommentController::class, 'manage']);
});

// UKM (Penyelenggara)
Route::middleware(['auth', 'role:ukm'])->group(function () {
    // Dashboard
    Route::get('/ukm/dashboard', [DashboardController::class, 'ukm'])->name('ukm.dashboard');

    Route::post('/ukm/post-event', [EventController::class, 'store']);
    Route::get('/ukm/ukm-profile', [UKMController::class, 'profile']);
    Route::get('/ukm/ukm-gallery', [GalleryController::class, 'index']);
    Route::post('/ukm/comments', [CommentController::class, 'store']);
});

// Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Dashboard
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswa'])->name('mahasiswa.dashboard');

    Route::get('/mahasiswa/registration-event', [EventRegistrationsController::class, 'registrationPage']);
    Route::post('/mahasiswa/comments', [CommentController::class, 'store']);
    Route::post('/mahasiswa/submit-report', [ReportController::class, 'store']);
});