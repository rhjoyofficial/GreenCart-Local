<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnalyticsController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::post('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');

    // Products Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

    // Orders Management
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Categories Management
    Route::resource('categories', CategoryController::class);

    // Sellers Management
    Route::resource('sellers', SellerController::class);
    Route::post('sellers/{seller}/toggle-status', [SellerController::class, 'toggleStatus'])->name('sellers.toggleStatus');
    Route::get('sellers/{seller}/products', [SellerController::class, 'products'])->name('sellers.products');
    Route::get('sellers/{seller}/orders', [SellerController::class, 'orders'])->name('sellers.orders');
    Route::get('sellers/{seller}/analytics', [SellerController::class, 'analytics'])->name('sellers.analytics');
    Route::get('sellers/{seller}/payouts', [SellerController::class, 'payouts'])->name('sellers.payouts');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/sales', [ReportsController::class, 'sales'])->name('sales');
        Route::get('/products', [ReportsController::class, 'products'])->name('products');
        Route::get('/sellers', [ReportsController::class, 'sellers'])->name('sellers');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'overview'])->name('overview');
        Route::get('/sales-trends', [AnalyticsController::class, 'salesTrends'])->name('salesTrends');
        Route::get('/customer-analytics', [AnalyticsController::class, 'customerAnalytics'])->name('customerAnalytics');
        Route::get('/product-analytics', [AnalyticsController::class, 'productAnalytics'])->name('productAnalytics');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/update', [SettingsController::class, 'update'])->name('update');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
