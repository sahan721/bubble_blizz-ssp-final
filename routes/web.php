<?php

use Illuminate\Support\Facades\Route;

// Landing
use App\Http\Controllers\LandingController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;

// Customer
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\FavoriteController as CustomerFavoriteController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

// Rider
use App\Http\Controllers\Rider\RiderController;

// Settings (from your route:list)
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('customer.home');
})->name('landing');



/*
|--------------------------------------------------------------------------
| Dashboard (exists in your route:list)
|--------------------------------------------------------------------------
| You already redirect users after login using LoginResponse to:
| admin/home, rider/home, customer/home
| So this can be a simple view or redirect. Keep it safe:
*/
Route::get('/dashboard', function () {
    return redirect()->route('landing');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Settings (available to any authenticated user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (matches your route:list)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/home', [AdminController::class, 'home'])->name('home');

    // Products management
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Customers management
    Route::get('/customers', [AdminUserController::class, 'customers'])->name('customers.index');
    Route::get('/customers/create', [AdminUserController::class, 'createCustomer'])->name('customers.create');
    Route::post('/customers', [AdminUserController::class, 'storeCustomer'])->name('customers.store');
    Route::get('/customers/{user}/edit', [AdminUserController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{user}', [AdminUserController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{user}', [AdminUserController::class, 'destroy'])->name('customers.destroy');

    // Riders management
    Route::get('/riders', [AdminUserController::class, 'riders'])->name('riders.index');
    Route::get('/riders/create', [AdminUserController::class, 'createRider'])->name('riders.create');
    Route::post('/riders', [AdminUserController::class, 'storeRider'])->name('riders.store');
    Route::get('/riders/{user}/edit', [AdminUserController::class, 'edit'])->name('riders.edit');
    Route::put('/riders/{user}', [AdminUserController::class, 'update'])->name('riders.update');
    Route::delete('/riders/{user}', [AdminUserController::class, 'destroy'])->name('riders.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/assign', [AdminOrderController::class, 'assign'])->name('orders.assign');
});

/*
|--------------------------------------------------------------------------
| Rider Routes (matches your route:list)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'rider'])->prefix('rider')->name('rider.')->group(function () {

    // In your route:list, rider/home maps to dashboard()
    Route::get('/home', [RiderController::class, 'dashboard'])->name('home');

    Route::get('/dashboard', [RiderController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [RiderController::class, 'orders'])->name('orders');
    Route::get('/orders/history', [RiderController::class, 'history'])->name('orders.history');

    Route::post('/orders/{order}/picked-up', [RiderController::class, 'markPickedUp'])->name('orders.picked_up');
    Route::post('/orders/{order}/delivered', [RiderController::class, 'markDelivered'])->name('orders.delivered');

    Route::get('/earnings', [RiderController::class, 'earnings'])->name('earnings');

    Route::get('/profile', [RiderController::class, 'profile'])->name('profile');
    Route::post('/profile', [RiderController::class, 'updateProfile'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Customer Routes (LOCKED to role:customer) (matches your route:list)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {

    Route::get('/customer/home', [CustomerHomeController::class, 'index'])->name('customer.home');

    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.products');

    Route::get('/favorites', [CustomerFavoriteController::class, 'index'])->name('customer.favorites');
    Route::post('/favorites/toggle', [CustomerFavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::get('/cart', [CustomerCartController::class, 'index'])->name('customer.cart');
    Route::post('/cart/add', [CustomerCartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CustomerCartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CustomerCartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CustomerCartController::class, 'clear'])->name('cart.clear');

    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    Route::post('/checkout/place-order', [CustomerOrderController::class, 'place'])->name('customer.place_order');

    Route::view('/packages', 'customer.packages')->name('customer.packages');
});
