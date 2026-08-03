<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\SeriController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

// Students Routes - Restricted
Route::resource('students', StudentController::class)->except(['index', 'show'])->middleware('auth');
Route::resource('students', StudentController::class)->only(['index', 'show']);

// Payments Routes
Route::get('/pembayaran', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
Route::post('/pembayaran', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

Route::middleware('auth')->group(function () {
    Route::get('/admin/pembayaran', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::put('/admin/pembayaran/{id}/approve', [App\Http\Controllers\PaymentController::class, 'approve'])->name('payments.approve');
});

// Other Resources
Route::resource('acara', AcaraController::class);
Route::resource('seri', SeriController::class);
Route::resource('lomba', LombaController::class);
Route::resource('club', ClubController::class);
