<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/','/ar');
Route::get('/switch-language/{locale}', [\App\Http\Controllers\Front\LocalController::class, 'switch'])->name('local.switch');
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect', 'localeViewPath']

],function(){
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/items',[CartController::class,'store'])->name('cart.items.store');
Route::patch('/cart/items/{cartItem}',[CartController::class,'update'])->name('cart.items.update');
Route::delete('/cart/items/{cartItem}',[CartController::class,'destroy'])->name('cart.items.destroy');

Route::get('/checkout',[CheckoutController::class,'checkout'])->name('checkout.create');
Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');
Route::get('/checkout/success/{order}',[CheckoutController::class,'success'])->name('checkout.success');


});
// require __DIR__.'/auth.php';
require __DIR__.'/role-permession.php';
require __DIR__ . '/dashboard.php';
require __DIR__ . '/user.php';