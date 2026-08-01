<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\SeriController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\StudentController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('students', StudentController::class);
Route::resource('acara', AcaraController::class);
Route::resource('seri', SeriController::class);
Route::resource('lomba', LombaController::class);
Route::resource('club', ClubController::class);
