<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\DashboardController;

Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

    // Orders
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'destroy']);
    Route::put('orders/{order}/update', [OrderController::class, 'update'])->name('orders.update');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/seller', [ProfileController::class, 'seller'])->name('profile.seller');
    Route::post('/profile/seller/business', [ProfileController::class, 'updateBusiness'])->name('profile.updateBusiness');
    Route::get('/profile/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    Route::post('/profile/addresses', [ProfileController::class, 'addAddress'])->name('profile.addAddress');
    Route::post('/profile/addresses/{addressId}/update', [ProfileController::class, 'updateAddress'])->name('profile.updateAddress');
    Route::delete('/profile/addresses/{addressId}', [ProfileController::class, 'deleteAddress'])->name('profile.deleteAddress');
    Route::post('/profile/addresses/{addressId}/set-default', [ProfileController::class, 'setDefaultAddress'])->name('profile.setDefaultAddress');
});
