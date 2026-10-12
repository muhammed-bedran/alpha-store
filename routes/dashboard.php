<?php

use App\Http\Controllers\Dashboard\AdminsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\StoresController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\TranslationController;
use App\Http\Controllers\Dashboard\HrController;
use App\Http\Controllers\Dashboard\HrDepartmentsController;
use App\Http\Controllers\Dashboard\HrEmployeesController;
use App\Http\Controllers\Dashboard\HrLeaveRequestsController;
use App\Http\Controllers\Dashboard\HrBonusesController;
use App\Http\Controllers\Dashboard\HrDeductionsController;
use App\Http\Controllers\Dashboard\HrPayrollsController;

// Route::group([],function(){});
Route::group([
'prefix' => '/admin/dashboard',
'as' => 'dashboard.',
'middleware' => ['auth:admin']
], function () {
Route::resource('admins',AdminsController::class);

Route::get('/index',[DashboardController::class,'index'])->name('index');
Route::get('/categories/index', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('/categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/categories/delete/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
Route::get('/categories/{category}/products', [CategoriesController::class, 'products'])->name('categories.products');
// Route::resource('categories',CategoriesController::class)->except(['show']);
Route::match(['post','put'],'/translate/{group}/{field}',[TranslationController::class,'translate'])
->name('translations.translate')
->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);

Route::match(['post','put'],'/translate/{group}/{field}/update',[TranslationController::class,'update'])
->name('translations.update')
->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);


Route::match(['post','put','delete'],'/translate/{group}/{field}/delete',[TranslationController::class,'destroy'])
->name('translations.destroy')
->where(['group' => '[a-z_]+', 'field' => '[a-z_]+']);

Route::resource('stores',StoresController::class);
Route::resource('products',ProductsController::class);

Route::prefix('hr')->name('hr.')->group(function () {
    Route::get('/', [HrController::class, 'index'])->name('index');
    Route::get('/about', [HrController::class, 'about'])->name('about');
    Route::resource('departments', HrDepartmentsController::class)->except(['show']);
    Route::resource('employees', HrEmployeesController::class)->except(['show']);
    Route::resource('leaves', HrLeaveRequestsController::class)
        ->parameters(['leaves' => 'leave'])
        ->except(['show']);
    Route::post('leaves/{leave}/approve', [HrLeaveRequestsController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [HrLeaveRequestsController::class, 'reject'])->name('leaves.reject');
    Route::resource('bonuses', HrBonusesController::class)
        ->parameters(['bonuses' => 'bonus'])
        ->except(['show']);
    Route::resource('deductions', HrDeductionsController::class)->except(['show']);
    Route::resource('payrolls', HrPayrollsController::class);
    Route::post('payrolls/{payroll}/pay', [HrPayrollsController::class, 'pay'])->name('payrolls.pay');
});

Route::get('/2fa', [App\Http\Controllers\Dashboard\TwoFactorAuthenticationController::class, 'index'])->name('admin.2fa');
});




