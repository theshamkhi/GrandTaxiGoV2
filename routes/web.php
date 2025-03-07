<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Trips
Route::resource('trips', TripController::class)->middleware(['auth']);
Route::patch('/trips/{trip}/update-status', [TripController::class, 'updateStatus'])->name('trips.update-status');

// Reviews
Route::post('/trips/{trip}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Availability (for drivers)
Route::resource('availability', AvailabilityController::class)->middleware(['auth', 'role:driver']);

// Socialite Login
Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);

// Payment (Stripe)
Route::get('/payment/{trip_id}/{price}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';