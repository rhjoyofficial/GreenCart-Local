<?php

use Illuminate\Support\Facades\Route;

// Load segmented route files
require __DIR__ . '/auth.php';
require __DIR__ . '/web/frontend.php';
require __DIR__ . '/web/customer.php';
require __DIR__ . '/web/seller.php';
require __DIR__ . '/web/admin.php';

// Shared Profile Routes for all authenticated users (fallback)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Webhooks (for payment gateways)
Route::prefix('webhooks')->name('webhooks.')->group(function () {
    Route::post('/payment/success')->name('payment.success');
    Route::post('/payment/failed')->name('payment.failed');
    Route::post('/payment/refund')->name('payment.refund');
});

// API Documentation
Route::get('/api/documentation', fn() => view('api.documentation'))->name('api.documentation');

// Fallback Route for 404
Route::fallback(fn() => response()->view('errors.404', [], 404));
