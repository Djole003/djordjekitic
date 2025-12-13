<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;

require __DIR__.'/auth.php';

// Rute dostupne svima (gostima i prijavljenima)
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/jela/{id}', [ProductController::class, 'showWithSuggestions'])->name('dish.showWithSuggestions');
Route::get('/jelovnik', [ProductController::class, 'jelovnikPoKategorijama'])->name('jelovnik');
Route::get('/jelovnik/kategorija/{slug}', [ProductController::class, 'showCategory'])->name('jelovnik.kategorija');
Route::get('/kontakt', [ContactController::class, 'show'])->name('contact.show');
Route::post('/kontakt/recenzija', [ContactController::class, 'submitReview'])->name('contact.review.submit');

// Korpa i dodavanje proizvoda – dostupno svima
Route::get('/korpa', [OrderController::class, 'showCart'])->name('order.cart');
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::delete('/korpa/ukloni/{id}', [OrderController::class, 'removeFromOrder'])->name('order.remove');
// Checkout stranica
Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');


// Završavanje porudžbine
Route::post('/poruci/zavrsi', [OrderController::class, 'submitOrder'])->name('order.submit');
Route::get('/thankyou', [OrderController::class, 'thankyou'])->name('order.thankyou');

// ------------------------
// ADMIN RUTE
// ------------------------

// Samo admin: dashboard i korisnici
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::post('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggleActive');
});

// Admin i editor: products i orders
Route::middleware(['auth', 'role:admin,editor'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->except(['show', 'create', 'store']);
    Route::post('orders/{id}/accept', [AdminOrderController::class, 'accept'])->name('orders.accept');
    Route::post('orders/{id}/delivered', [AdminOrderController::class, 'delivered'])->name('orders.delivered');
});


// ------------------------
// KORISNIK: pregled narudžbina
// ------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/orders', [\App\Http\Controllers\UserOrderController::class, 'index'])->name('user.orders.index');
});
