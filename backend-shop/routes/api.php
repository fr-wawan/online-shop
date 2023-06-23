<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/newest', [ProductController::class, 'newestProduct']);
Route::get('/product/{slug}', [ProductController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth:api');
Route::post('/profile', [ProfileController::class, 'update'])->middleware('auth:api');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('auth:api');

Route::get('/cart', [CartController::class, 'index'])->middleware('auth:api');
Route::post('/cart', [CartController::class, 'store'])->middleware('auth:api');
Route::put('/cart/{id}', [CartController::class, 'update'])->middleware('auth:api');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->middleware('auth:api');


Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth:api');
Route::post('/transaction/cod', [TransactionController::class, 'paymentCod'])->middleware('auth:api');
Route::post('/transaction/midtrans', [TransactionController::class, 'paymentMidtrans'])->middleware('auth:api');
Route::get('/transaction/{invoice}', [TransactionController::class, 'show'])->middleware('auth:api');
Route::post('/transaction/notification', [TransactionController::class, 'notificationHandler']);
