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

// Income and Expense Routes
Route::post('/income', [\App\Http\Controllers\IncomeController::class, 'store'])->middleware('auth')->name('income.store');
Route::post('/expense', [\App\Http\Controllers\ExpenseController::class, 'store'])->middleware('auth')->name('expense.store');

// Transaction Routes
Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index'])->middleware('auth')->name('transactions.index');
Route::put('/income/{income}', [\App\Http\Controllers\TransactionController::class, 'updateIncome'])->middleware('auth')->name('income.update');
Route::delete('/income/{income}', [\App\Http\Controllers\TransactionController::class, 'destroyIncome'])->middleware('auth')->name('income.destroy');
Route::put('/expense/{expense}', [\App\Http\Controllers\TransactionController::class, 'updateExpense'])->middleware('auth')->name('expense.update');
Route::delete('/expense/{expense}', [\App\Http\Controllers\TransactionController::class, 'destroyExpense'])->middleware('auth')->name('expense.destroy');
