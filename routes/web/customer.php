<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders/history', [DashboardController::class, 'orders'])->name('dashboard.orders-history');
    Route::get('/wishlist', [DashboardController::class, 'wishlist'])->name('dashboard.wishlist');
    Route::get('/addresses', [DashboardController::class, 'addresses'])->name('dashboard.addresses');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');

    // Profile
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');
    Route::post('/profile/change-password', [DashboardController::class, 'changePassword'])->name('dashboard.changePassword');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::resource('orders', OrderController::class)->only(['index', 'show']);

    // Profile (Shared but logic handled here)
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
