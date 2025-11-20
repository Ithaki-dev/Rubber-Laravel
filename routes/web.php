<?php

use App\Http\Controllers\ProfileController;
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
    
    // Vehicle routes (only for drivers)
    Route::resource('vehicles', \App\Http\Controllers\VehicleController::class);
    
    // Ride routes (only for drivers)
    Route::resource('rides', \App\Http\Controllers\RideController::class);
    
    // Reservation routes
    Route::resource('reservations', \App\Http\Controllers\ReservationController::class)->only(['index', 'store', 'destroy']);
    Route::patch('reservations/{reservation}/accept', [\App\Http\Controllers\ReservationController::class, 'accept'])->name('reservations.accept');
    Route::patch('reservations/{reservation}/reject', [\App\Http\Controllers\ReservationController::class, 'reject'])->name('reservations.reject');
    
    // Admin routes
    Route::middleware('can:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\AdminController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});

// Public routes
Route::get('/rides/search', [\App\Http\Controllers\PublicController::class, 'index'])->name('rides.search');
Route::get('/rides/{ride}/details', [\App\Http\Controllers\PublicController::class, 'show'])->name('rides.details');

require __DIR__.'/auth.php';
