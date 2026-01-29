<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\EnsureRestaurantSelected;
use App\Http\Middleware\RestrictAdminToRestaurant;


use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\RestaurantSelectController;

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| ROOT (/) – IZBOR LOKALA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    // Ako je ulogovan ADMIN → nema šta da traži ovde
    if (
        auth()->check() &&
        auth()->user()->role === 'admin'
    ) {
        return redirect()->route('index'); // /pocetna
    }

    // Sve ostalo (gost + editor)
    return app(\App\Http\Controllers\RestaurantSelectController::class)->index();

})->name('select.restaurant');

Route::post('/izaberi-lokal', function () {

    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('index');
    }

    return app(\App\Http\Controllers\RestaurantSelectController::class)->select(
        request()
    );

})->name('select.restaurant.store');



/*
|--------------------------------------------------------------------------
| CELOKUPAN SAJT – ZAKLJUČAN DOK SE NE IZABERE LOKAL
|--------------------------------------------------------------------------
*/
Route::middleware([EnsureRestaurantSelected::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | POČETNA STRANA SAJTA
    |--------------------------------------------------------------------------
    */
    Route::get('/pocetna', [ProductController::class, 'index'])
        ->name('index');

    /*
    |--------------------------------------------------------------------------
    | JAVNI DEO
    |--------------------------------------------------------------------------
    */
    Route::get('/jela/{id}', [ProductController::class, 'showWithSuggestions'])
        ->name('dish.showWithSuggestions');

    Route::get('/jelovnik', [ProductController::class, 'jelovnikPoKategorijama'])
        ->name('jelovnik');

    Route::get('/jelovnik/kategorija/{slug}', [ProductController::class, 'showCategory'])
        ->name('jelovnik.kategorija');

    Route::get('/kontakt', [ContactController::class, 'show'])
        ->name('contact.show');

    Route::post('/kontakt/recenzija', [ContactController::class, 'submitReview'])
        ->name('contact.review.submit');


    /*
    |--------------------------------------------------------------------------
    | KORPA / PORUDŽBINE
    |--------------------------------------------------------------------------
    */
    Route::get('/korpa', [OrderController::class, 'showCart'])
        ->name('order.cart');

    Route::post('/cart/add', [OrderController::class, 'addToCart'])
        ->name('cart.add');

    Route::delete('/korpa/ukloni/{index}', [OrderController::class, 'removeFromOrder'])
        ->name('order.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('order.checkout');

    Route::post('/poruci/zavrsi', [OrderController::class, 'submitOrder'])
        ->middleware('restaurant.open')
        ->name('order.submit');

    Route::get('/thankyou', [OrderController::class, 'thankyou'])
        ->name('order.thankyou');


    /*
    |--------------------------------------------------------------------------
    | TIP PORUDŽBINE / DOSTAVA
    |--------------------------------------------------------------------------
    */
    Route::get('/select-order-type/{type}', function ($type) {
        if (!in_array($type, ['delivery', 'takeaway'])) {
            $type = 'delivery';
        }

        session(['order_type' => $type]);
        return response()->json(['status' => 'ok']);
    });

    Route::post('/check-delivery-zone', [OrderController::class, 'checkDeliveryZone'])
        ->name('delivery.zone.check');

    Route::post('/delivery/check', [DeliveryController::class, 'check'])
        ->name('delivery.check');


    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL – EDITOR 
    |--------------------------------------------------------------------------
    */

    Route::post('/switch-restaurant', function (\Illuminate\Http\Request $request) {

        // samo editor
        if (auth()->user()->role !== 'editor') {
            abort(403);
        }

        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);

        session([
            'restaurant_id' => $request->restaurant_id
        ]);

        return back();

    })->name('admin.switchRestaurant');


    Route::middleware([
        'auth',
        'role:editor' // 👈 SAMO TI
    ])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::post('/users/{id}/role', [AdminUserController::class, 'updateRole'])
            ->name('users.updateRole');

        Route::post('/users/{id}/toggle-active', [AdminUserController::class, 'toggleActive'])
            ->name('users.toggleActive');
    });



    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL – EDITOR + ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware([
        'auth',
        'role:admin,editor',
        RestrictAdminToRestaurant::class
    ])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $restaurantOpen = DB::table('restaurant_status')->value('is_open');
            return view('admin.dashboard', compact('restaurantOpen'));
        })->name('dashboard');


        // STATUS RESTORANA
        Route::post('/restaurant/toggle', [\App\Http\Controllers\Admin\RestaurantStatusController::class, 'toggle'])
            ->name('restaurant.toggle');

        // FCM
        Route::post('/save-fcm-token', [\App\Http\Controllers\Admin\AdminFcmController::class, 'store'])
            ->name('admin.fcm.store');

        // PRODUCTS
        Route::resource('products', AdminProductController::class);
        Route::post(
            'products/{product}/toggle-availability',
            [AdminProductController::class, 'toggleAvailability']
        )->name('products.toggleAvailability');


        // ORDERS
        Route::resource('orders', AdminOrderController::class)
            ->except(['show', 'create', 'store']);

        Route::post('orders/{order}/accept', [AdminOrderController::class, 'accept'])
            ->name('orders.accept');

        Route::post('orders/{order}/ready', [AdminOrderController::class, 'ready'])
            ->name('orders.ready');

        Route::get('/orders/history', [AdminOrderController::class, 'history'])
            ->name('orders.history');
    });



    /*
    |--------------------------------------------------------------------------
    | KORISNIK – NARUDŽBINE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {

        Route::get('/profile/orders', [\App\Http\Controllers\UserOrderController::class, 'index'])
            ->name('user.orders.index');

        Route::post('/profile/orders/{order}/repeat', [\App\Http\Controllers\UserOrderController::class, 'repeat'])
            ->name('orders.repeat');
    });

});
