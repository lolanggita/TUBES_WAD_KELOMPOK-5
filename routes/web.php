<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashUkmController;
use App\Http\Controllers\Dashboard\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UKMController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === Login & Logout Routes ===
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::guard()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// === Dashboard Redirect Based on Role ===
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'administrator') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'ukm') {
        return redirect()->route('ukm.dashboard');
    } elseif ($user->role === 'mahasiswa') {
        return redirect()->route('mahasiswa.dashboard');
    }

    return abort(403, 'Unauthorized access.');
})->middleware(['auth', 'verified'])->name('dashboard');

// === Profile Route ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// === ADMIN ROUTES ===
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Manage Users
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('index');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('destroy');

    // Manage UKMs
    Route::get('/ukms', [AdminController::class, 'manageUkms'])->name('index');
    Route::get('/ukms/create', [AdminController::class, 'createUkm'])->name('create');
    Route::post('/ukms', [AdminController::class, 'storeUkm'])->name('store');
    Route::get('/ukms/{id}/edit', [AdminController::class, 'editUkm'])->name('edit');
    Route::put('/ukms/{id}', [AdminController::class, 'updateUkm'])->name('update');
    Route::delete('/ukms/{id}', [AdminController::class, 'deleteUkm'])->name('destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('index');
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('show');
    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('edit');
    Route::put('/reports/{id}', [ReportController::class, 'update'])->name('update');
    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('destroy');

    // Event Management
    Route::get('/events', [EventController::class, 'index'])->name('index');
    Route::get('/events/create', [EventController::class, 'create'])->name('create');
    Route::post('/', [EventController::class, 'store'])->name('store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('destroy');

    // Comment Management
    Route::get('/', [CommentController::class, 'index'])->name('index');
    Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
    Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');

    // UKM Verification
    Route::post('/verify-ukm', [UKMController::class, 'verify'])->name('ukm.verify');
});

// === UKM ROUTES ===
Route::middleware(['auth', 'role:ukm'])->prefix('ukm')->name('ukm.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashUkmController::class, 'index'])->name('dashboard');

    // UKM Profile
    Route::get('/profile', [UKMController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UKMController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UKMController::class, 'updateProfile'])->name('profile.update');

    // UKM CRUD
    Route::get('/', [UKMController::class, 'index'])->name('index');
    Route::get('/create', [UKMController::class, 'create'])->name('create');
    Route::post('/', [UKMController::class, 'store'])->name('store');
    Route::get('/{ukm}', [UKMController::class, 'show'])->name('show');
    Route::get('/{ukm}/edit', [UKMController::class, 'edit'])->name('edit');
    Route::put('/{ukm}', [UKMController::class, 'update'])->name('update');
    Route::delete('/{ukm}', [UKMController::class, 'destroy'])->name('destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('index');
    Route::get('/events/create', [EventController::class, 'create'])->name('create');
    Route::post('/', [EventController::class, 'store'])->name('store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('destroy');

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{id}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::get('/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});

// === MAHASISWA ROUTES ===
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');

    // Registrasi Event
    Route::get('/registration-event', [EventRegistrationsController::class, 'registrationPage'])->name('registration.page');

    // Report
    Route::post('/submit-report', [ReportController::class, 'store'])->name('report.submit');

    // Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');
});

// === Shared Comment Routes (All Authenticated Users) ===
Route::middleware('auth')->group(function () {
    Route::post('/event/{event}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
});