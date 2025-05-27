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

// Rute dostupne samo prijavljenim korisnicima (sve osim login/registracija)
Route::middleware('auth')->group(function () {
    // Rute dostupne svim ulogama
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/jela/{id}/', [ProductController::class, 'showWithSuggestions'])->name('dish.showWithSuggestions');
    Route::get('/jelovnik', [ProductController::class, 'jelovnikPoKategorijama'])->name('jelovnik');

    Route::get('/poruci/{id}', [OrderController::class, 'addToOrder'])->name('order.add');
    Route::post('/poruci/zavrsi', [OrderController::class, 'submitOrder'])->name('order.submit');
    Route::get('/thankyou', [OrderController::class, 'thankyou'])->name('order.thankyou');
    Route::get('/korpa', [OrderController::class, 'showCart'])->name('order.cart');
    Route::delete('/korpa/ukloni/{id}', [OrderController::class, 'removeFromOrder'])->name('order.remove');

    Route::get('/kontakt', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/kontakt/recenzija', [ContactController::class, 'submitReview'])->name('contact.review.submit');

    // Rute samo za admin



    // Samo admin: dashboard i korisnici
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggleActive');
    });

    // Admin i editor: products, orders, reviews
    Route::middleware(['auth', 'role:admin,editor'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', AdminProductController::class);
        Route::resource('orders', AdminOrderController::class)->except(['show', 'create', 'store']);


    });




    
});
