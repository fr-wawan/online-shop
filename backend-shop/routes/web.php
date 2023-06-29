<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('admin')->group(function () {
    Route::group(['middleware', 'auth'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::resource('/category', CategoryController::class, ['as' => 'admin'])->except('show');
        Route::resource('/product', ProductController::class, ['as' => 'admin'])->except('show');
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');
        Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction.index');


        Route::get('/transaction/filter', [TransactionController::class, 'filter'])->name('admin.transaction.filter');
        Route::get('/transaction/{invoice}', [TransactionController::class, 'show'])->name('admin.transaction.show');
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');
    });
});
