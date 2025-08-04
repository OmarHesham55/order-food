<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->is_admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('order_food.home');
    } else {
        return redirect()->route('login');
    }
});

/* Home Page for Users  */
Route::prefix('/order_food')->middleware(['auth'])->group(function (){
    Route::get('/restaurants_menu',[\App\Http\Controllers\HomeController::class,'index'])
        ->middleware(['auth'])
        ->name('order_food.home');

    Route::post('/add_to_cart',[\App\Http\Controllers\CartController::class,'addCart'])
        ->middleware(['auth'])
        ->name('cart.add');

    Route::get('/cart_items',[\App\Http\Controllers\CartController::class,'getCartItems'])
        ->middleware(['auth'])
        ->name('cart.get');

    Route::post('/cart_clear',[\App\Http\Controllers\CartController::class,'clearCart'])
        ->middleware(['auth'])
        ->name('cart.clear');

    Route::post('/remove_item_cart',[\App\Http\Controllers\CartController::class,'removeItem'])
        ->middleware(['auth'])
        ->name('cart.item.clear');

    Route::post('/place_order',[\App\Http\Controllers\CartController::class,'placeOrder'])
        ->middleware(['auth'])
        ->name('order.placed');

    Route::get('/my_orders',[\App\Http\Controllers\OrderController::class,'index'])
        ->middleware(['auth'])
        ->name('orders.show');

});


/* Admin Dashboard */
Route::get('/admin/dashboard',[\App\Http\Controllers\AdminDashboardController::class,'index'])
    ->name('admin.dashboard')
    ->middleware(['auth']);

/* Logout */
Route::post('/logout',[\App\Http\Controllers\Auth\AuthenticatedSessionController::class,'logout'])
    ->middleware(['auth'])
    ->name('logout');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/* Profile */
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});


/* Admin Panel Routes */
Route::prefix('/dashboard/admin')->middleware(['auth'])->group(function (){

    /* Categories */
    Route::controller(\App\Http\Controllers\CategoryController::class)->prefix('categories')
        ->name('categories.')
        ->group(function (){
        Route::get('/','index')->name('index');
        Route::get('/get-data','getData');
        Route::post('/','store')->name('store');
        Route::get('/{id}','show')->name('show');
        Route::delete('/{category}','destroy')->name('destroy');
    });

    /* Meals */
    Route::controller(\App\Http\Controllers\MealsController::class)->prefix('meals')
        ->name('meals.')
        ->group(function (){
           Route::get('/','index')->name('index');
           Route::post('/','store')->name('store');
           Route::put('/{id}','update')->name('update');
           Route::delete('{id}','destroy')->name('destroy');
           Route::get('/by-restaurant/{id}','getByRestaurant')->name('getByRestaurant');
        });

    /* Restaurants */
    Route::resource('/restaurants',\App\Http\Controllers\RestaurantsController::class)
        ->names('restaurants');
    Route::get('/all_restaurants',[\App\Http\Controllers\RestaurantsController::class,'all'])
        ->name('restaurants.all');

    /* Admin Orders */
    Route::get('/all_orders',[\App\Http\Controllers\OrderAdminController::class,'index'])
        ->name('admin.orders.index');
    Route::post('/orders/update_order',[\App\Http\Controllers\OrderAdminController::class,'orderStatus'])
        ->name('admin.update.order');
});

require __DIR__.'/auth.php';
