<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'approved']);
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Approval Routes
Route::get('/approval', function () {
    return view('auth.approval');
})->middleware('auth')->name('approval.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// SSO Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('sso.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\SocialiteController::class, 'callback']);

// Registration Routes
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Profile Routes
Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/complete', [App\Http\Controllers\ProfileController::class, 'complete'])->name('profile.complete');
});

// Students Routes - Restricted
Route::resource('students', StudentController::class)->except(['index', 'show'])->middleware(['auth', 'approved']);
Route::put('students/{id}/evaluation', [StudentController::class, 'updateEvaluation'])->name('students.updateEvaluation')->middleware(['auth', 'approved']);
Route::resource('students', StudentController::class)->only(['index', 'show'])->middleware('approved');

// Payments Routes
Route::get('/pembayaran', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
Route::post('/pembayaran', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');

Route::middleware(['auth', 'approved'])->group(function () {
    Route::get('/admin/pembayaran', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::put('/admin/pembayaran/{id}/approve', [App\Http\Controllers\PaymentController::class, 'approve'])->name('payments.approve');
});

// Programs Routes
use App\Http\Controllers\ProgramController;
Route::resource('programs', ProgramController::class)->middleware(['auth', 'approved']);

// Other Resources
// Other Resources
Route::post('/coaches', [DashboardController::class, 'storeCoach'])->name('coaches.store')->middleware(['auth', 'approved']);
Route::post('/coaches/bulk-destroy', [DashboardController::class, 'bulkDestroyCoaches'])->name('coaches.bulkDestroy')->middleware(['auth', 'approved']);
Route::put('/coaches/{id}', [DashboardController::class, 'updateCoach'])->name('coaches.update')->middleware(['auth', 'approved']);
Route::delete('/coaches/{id}', [DashboardController::class, 'destroyCoach'])->name('coaches.destroy')->middleware(['auth', 'approved']);

Route::post('/parents/bulk-destroy', [DashboardController::class, 'bulkDestroyParents'])->name('parents.bulkDestroy')->middleware(['auth', 'approved']);
Route::put('/parents/{id}', [DashboardController::class, 'updateParent'])->name('parents.update')->middleware(['auth', 'approved']);
Route::delete('/parents/{id}', [DashboardController::class, 'destroyParent'])->name('parents.destroy')->middleware(['auth', 'approved']);
Route::post('/parents/{id}/approve', [DashboardController::class, 'approveParent'])->name('parents.approve')->middleware(['auth', 'approved']);
