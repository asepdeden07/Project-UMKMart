<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsCustomer;
use App\Http\Controllers\Admin\SettingsController;

/**
 * PUBLIC ROUTES
 */
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

/**
 * ADMIN AUTH ROUTES (Halaman Login Terpisah Khusus Admin)
 */
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'storeAdmin']);
});

/**
 * AUTHENTICATED ROUTES
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * ADMIN ROUTES
 */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('products', AdminProductController::class);
    
    // Manajemen Pesanan Admin
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
    
    // Manajemen Pengaturan Website
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/hero-banner', [SettingsController::class, 'updateHeroBanner'])->name('settings.banner.update');
    Route::post('/settings/logo', [SettingsController::class, 'updateWebsiteLogo'])->name('settings.logo.update');
    Route::delete('/settings/hero-banner', [SettingsController::class, 'deleteHeroBanner'])->name('settings.banner.destroy');
    Route::delete('/settings/logo', [SettingsController::class, 'deleteWebsiteLogo'])->name('settings.logo.destroy');
    Route::post('/settings/details', [SettingsController::class, 'updateWebsiteDetails'])->name('settings.details.update');
    Route::post('/settings/update-hero-background', [App\Http\Controllers\Admin\SettingsController::class, 'updateHeroBackground'])
         ->name('settings.updateHeroBackground');
   
});

/**
 * CUSTOMER ROUTES
 */
Route::middleware(['auth', 'customer'])->group(function () {
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/{cartItem}', [CartController::class, 'update'])->name('update');
        Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'show'])->name('show');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
    });

    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [CustomerOrderController::class, 'show'])->name('show');
    });
     
});

// Jalur login bawaan untuk customer biasa
require __DIR__.'/auth.php';