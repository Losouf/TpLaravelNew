<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DishController;

Route::get('/', fn() => redirect()->route('dishes.index'));

Route::middleware('auth')->group(function () {
    Route::resource('dishes', DishController::class);
    Route::post('dishes/{dish}/favorite', [DishController::class,'favorite'])->name('dishes.favorite');
    Route::delete('dishes/{dish}/favorite', [DishController::class,'unfavorite'])->name('dishes.unfavorite');

    Route::get('favorites', [DishController::class,'favorites'])->name('dishes.favorites');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
