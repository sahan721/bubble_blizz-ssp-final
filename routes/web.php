<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Rider\RiderController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\FavoriteController as CustomerFavoriteController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\TwoFactorSettingsController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('home');
    Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Products Management
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
});

// Rider Routes
Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/home', [RiderController::class, 'index'])->name('home');
    Route::get('/orders', [RiderController::class, 'orders'])->name('orders');
    Route::put('/orders/{order}/accept', [RiderController::class, 'acceptOrder'])->name('orders.accept');
    Route::put('/orders/{order}/pickup', [RiderController::class, 'pickupOrder'])->name('orders.pickup');
    Route::put('/orders/{order}/deliver', [RiderController::class, 'deliverOrder'])->name('orders.deliver');
});

// Customer Routes
Route::middleware(['auth', 'role:customer', 'EnsureTwoFactorVerified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/home', [CustomerHomeController::class, 'index'])->name('home');
    // Products route
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products');
    // Cart routes
    Route::get('/cart', [CustomerCartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CustomerCartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CustomerCartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CustomerCartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CustomerCartController::class, 'clear'])->name('cart.clear');
    // Orders routes
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [CustomerOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    // Favorites routes
    Route::get('/favorites', [CustomerFavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [CustomerFavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{favorite}', [CustomerFavoriteController::class, 'destroy'])->name('favorites.destroy');
    // Packages route (redirecting to products for now)
    Route::get('/packages', [CustomerProductController::class, 'index'])->name('packages');
});

// Settings Routes (for all authenticated users)
Route::middleware(['auth'])->prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    Route::post('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
    Route::get('/security', [SettingsController::class, 'security'])->name('security');
    Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
});

// Social Login Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

// Two-Factor Authentication Routes
Route::middleware('auth')->prefix('two-factor')->name('two-factor.')->group(function () {
    Route::get('/settings', [TwoFactorSettingsController::class, 'index'])->name('settings');
    Route::post('/enable', [TwoFactorSettingsController::class, 'enable'])->name('enable');
    Route::post('/disable', [TwoFactorSettingsController::class, 'disable'])->name('disable');
    Route::get('/qr-code', [TwoFactorSettingsController::class, 'showQrCode'])->name('qr-code');
    Route::post('/confirm-totp', [TwoFactorSettingsController::class, 'confirmTotp'])->name('confirm-totp');
    Route::get('/recovery-codes', [TwoFactorSettingsController::class, 'showRecoveryCodes'])->name('recovery-codes');
});

Route::middleware('auth')->group(function () {
    Route::get('/two-factor/challenge', [TwoFactorChallengeController::class, 'show'])->name('two-factor.challenge');
    Route::post('/two-factor/verify', [TwoFactorChallengeController::class, 'verify'])->name('two-factor.verify');
    Route::post('/two-factor/resend-email', [TwoFactorChallengeController::class, 'resendEmailCode'])->name('two-factor.resend-email');
});


// Jetstream authentication routes are loaded via FortifyServiceProvider