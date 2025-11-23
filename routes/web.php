<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Public routes (MUST be before resource routes to avoid conflicts)
Route::get('/rides/search', [\App\Http\Controllers\PublicController::class, 'index'])->name('rides.search');
Route::get('/rides/{ride}/details', [\App\Http\Controllers\PublicController::class, 'show'])->name('rides.details');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Resource routes
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);
    Route::resource('rides', \App\Http\Controllers\RideController::class);
    
    // Reservation routes
    Route::resource('reservations', \App\Http\Controllers\ReservationController::class)->only(['index', 'store', 'destroy']);
    Route::post('reservations/{reservation}/accept', [\App\Http\Controllers\ReservationController::class, 'accept'])->name('reservations.accept');
    Route::post('reservations/{reservation}/reject', [\App\Http\Controllers\ReservationController::class, 'reject'])->name('reservations.reject');
    
    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});

require __DIR__.'/auth.php';
