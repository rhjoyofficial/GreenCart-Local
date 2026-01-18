<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CategoryController as CustomerCategoryController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\WishlistController as CustomerWishlistController;

// Static Pages
Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
Route::get('/about', [FrontendHomeController::class, 'about'])->name('about');
Route::controller(HomeController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit')->name('contact.submit');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/faqs', 'faqs')->name('faqs');
});

// Browsing
Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [CustomerProductController::class, 'show'])->name('products.show');
Route::get('/categories', [CustomerCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CustomerCategoryController::class, 'show'])->name('categories.show');

// Cart & Wishlist
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CustomerCartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CustomerCartController::class, 'add'])->name('add');
    Route::put('/update/{item}', [CustomerCartController::class, 'update'])->name('update');
    Route::delete('/remove/{item}', [CustomerCartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CustomerCartController::class, 'clear'])->name('clear');
});

Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [CustomerWishlistController::class, 'index'])->name('index');
    Route::post('/toggle/{product}', [CustomerWishlistController::class, 'toggle'])->name('toggle');
});
