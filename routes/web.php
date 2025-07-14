<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/dashboard/admin/categories',\App\Http\Controllers\CategoryController::class)
    ->middleware(['auth'])
    ->names('categories');
Route::resource('/dashboard/admin/restaurants',\App\Http\Controllers\RestaurantsController::class)
    ->middleware(['auth'])
    ->names('restaurants');
Route::get('/dashboard/admin/all_restaurants',[\App\Http\Controllers\RestaurantsController::class,'all'])
    ->middleware(['auth'])
    ->name('restaurants.all');

Route::get('/dashboard/admin/meals',[\App\Http\Controllers\MealsController::class,'index'])
    ->middleware(['auth'])
    ->name('meals.index');
Route::post('/dashboard/admin/meals',[\App\Http\Controllers\MealsController::class,'store'])
    ->middleware(['auth'])
    ->name('meals.store');
Route::post('/dashboard/admin/meals/{id}',[\App\Http\Controllers\MealsController::class,'update'])
    ->middleware(['auth'])
    ->name('meals.update');
Route::delete('/dashboard/admin/meals/{id}',[\App\Http\Controllers\MealsController::class,'destroy'])
    ->middleware(['auth'])
    ->name('meals.destroy');
Route::get('/dashboard/admin/meals/by-restaurant/{id}',[\App\Http\Controllers\MealsController::class,'getByRestaurant'])
    ->middleware(['auth'])
    ->name('getByRestaurant');
require __DIR__.'/auth.php';
