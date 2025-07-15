<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Routes for Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function (){
       return view('admin.dashboard');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout',[\App\Http\Controllers\Auth\AuthenticatedSessionController::class,'logout'])
    ->middleware(['auth'])
    ->name('logout');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('/dashboard/admin')->middleware(['auth'])->group(function (){
    Route::get('/categories',[\App\Http\Controllers\CategoryController::class,'index'])->name('categories.index');
    Route::post('/categories',[\App\Http\Controllers\CategoryController::class,'store'])->name('categories.store');
    Route::get('/categories/{id}',[\App\Http\Controllers\CategoryController::class,'show'])->name('categories.show');
    Route::delete('/categories/{category}',[\App\Http\Controllers\CategoryController::class,'destroy'])->name('categories.destroy');
});


Route::resource('/dashboard/admin/restaurants',\App\Http\Controllers\RestaurantsController::class)
    ->middleware(['auth'])
    ->names('restaurants');
Route::get('/dashboard/admin/all_restaurants',[\App\Http\Controllers\RestaurantsController::class,'all'])
    ->middleware(['auth'])
    ->name('restaurants.all');


Route::prefix('dashboard/admin')->middleware(['auth'])->group(function (){
    Route::get('/meals',[\App\Http\Controllers\MealsController::class,'index'])->name('meals.index');
    Route::post('/meals',[\App\Http\Controllers\MealsController::class,'store'])->name('meals.store');
    Route::post('/meals/{id}',[\App\Http\Controllers\MealsController::class,'update'])->name('meals.update');
    Route::delete('/meals/{id}',[\App\Http\Controllers\MealsController::class,'destroy'])->name('meals.destroy');
    Route::get('/meals/by-restaurant/{id}',[\App\Http\Controllers\MealsController::class,'getByRestaurant'])->name('getByRestaurant');
});


require __DIR__.'/auth.php';
