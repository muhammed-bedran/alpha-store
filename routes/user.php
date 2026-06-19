<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\ProductController;

// Route::group([],function(){});
Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => ['auth:web']
], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [StoreController::class, 'store'])->name('store.store');

    Route::middleware('user.has.store')->group(function () {
        Route::get('/store', [StoreController::class, 'edit'])->name('store.edit');
        Route::put('/store', [StoreController::class, 'update'])->name('store.update');
        Route::resource('products',ProductController::class);
    });
});
