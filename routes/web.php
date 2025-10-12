<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/register', function () {
    return Inertia::render('auth/Register');
})->middleware('guest')->name('register');

Route::get('/login', function () {
    return Inertia::render('auth/Login');
})->middleware('guest')->name('login');

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
