<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\StoreController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\TeamController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TwoFactorAuthenticationController;

// Route::group([],function(){});
Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => ['auth:web']
], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('2fa');
    // profile routes
    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::put('/profile',[ProfileController::class,'update'])->name('profile.update');

    // store routes
    Route::get('/store/create', [StoreController::class, 'create'])->name('store.create');
    Route::post('/store', [StoreController::class, 'store'])->name('store.store');

    // store routes with middleware user.has.store
    Route::middleware('user.has.store')->group(function () {
        Route::get('/store', [StoreController::class, 'edit'])->name('store.edit');
        Route::put('/store', [StoreController::class, 'update'])->name('store.update');
        Route::resource('products', ProductController::class);
        // Team Routes

        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::get('/team/create', [TeamController::class, 'create'])->name('team.create');
        Route::post('/team/store', [TeamController::class, 'store'])->name('team.store');
        Route::get('/team/edit/{member}', [TeamController::class, 'edit'])->name('team.edit');
        Route::put('/team/update/{member}', [TeamController::class, 'update'])->name('team.update');
        Route::delete('/team/delete/{member}', [TeamController::class, 'destroy'])->name('team.destroy');
    });
});
