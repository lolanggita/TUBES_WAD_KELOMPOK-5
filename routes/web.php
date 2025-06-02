<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UKMController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', function () {
    Auth::guard()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

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

    // Profil UKM
    Route::get('/ukm/ukm-profile', [UKMController::class, 'profile'])->name('ukm.profile');
    Route::get('/ukm/ukm-profile/edit', [UKMController::class, 'editProfile'])->name('ukm.profile.edit');
    Route::put('/ukm/ukm-profile', [UKMController::class, 'updateProfile'])->name('ukm.profile.update');
    
    // Form dan aksi store/update/delete UKM
    Route::get('/ukm', [UKMController::class, 'index'])->name('ukm.index');
    Route::get('/ukm/create', [UKMController::class, 'create'])->name('ukm.create');
    Route::post('/ukm', [UKMController::class, 'store'])->name('ukm.store');
    Route::get('/ukm/{ukm}', [UKMController::class, 'show'])->name('ukm.show');
    Route::get('/ukm/{ukm}/edit', [UKMController::class, 'edit'])->name('ukm.edit');
    Route::put('/ukm/{ukm}', [UKMController::class, 'update'])->name('ukm.update');
    Route::delete('/ukm/{ukm}', [UKMController::class, 'destroy'])->name('ukm.destroy');

    // Event
    Route::post('/ukm/post-event', [EventController::class, 'store']);

    // Gallery
    Route::get('/ukm/ukm-gallery', [GalleryController::class, 'index']);
});

// Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    // Dashboard
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswa'])->name('mahasiswa.dashboard');

    Route::get('/mahasiswa/registration-event', [EventRegistrationsController::class, 'registrationPage']);
    Route::post('/mahasiswa/comments', [CommentController::class, 'store']);
    Route::post('/mahasiswa/submit-report', [ReportController::class, 'store']);
});

// Comment Routes - Bisa diakses oleh semua role yang login
Route::middleware('auth')->group(function () {
    Route::post('/event/{event}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});