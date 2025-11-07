<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product-list', [HomeController::class, 'list'])->name('product.list');
Route::get('/product-list/category/{id}', [HomeController::class, 'getProductByCategory'])->name('product.category');
Route::get('/product-list/brand/{id}', [HomeController::class, 'getProductByBrand'])->name('product.brand');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('regular.user')->group(function () {
    Route::prefix('my-account')
        ->name('my-account.')
        ->group(function () {
            Route::get('/', [OrderController::class, 'orderList'])->name('orders');
            Route::post('/update-account', [UserController::class, 'updateAccount'])->name('update-account');
            Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');
            Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order');
            Route::put('/order/{id}', [OrderController::class, 'cancelOrder'])->name('cancel');
        });

    Route::prefix('cart')
        ->name('cart.')
        ->group(function () {
            Route::get('/', [CartController::class, 'show'])->name('list');
            Route::post('/items', [CartController::class, 'addItem'])->name('addItem');
            Route::put('/items/{cartItemId}', [CartController::class, 'updateItem'])->name('updateItem');
            Route::delete('/items/{cartItemId}', [CartController::class, 'removeItem'])->name('removeItem');
            Route::delete('/', [CartController::class, 'clear'])->name('clear');
        });

    Route::get('/checkout', [CheckOutController::class, 'showCheckOut'])->name('checkout');
    Route::post('/checkout', [CheckOutController::class, 'processCheckOut'])->name('checkout.process');
    Route::get('/checkout/success/{orderCode}', [CheckOutController::class, 'checkoutSuccess'])->name('checkout.success');
});
