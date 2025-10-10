<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('regular.user')->group(function () {
    Route::get('/my-account', [UserController::class, 'index'])->name('my-account');

    Route::get('/cart', function () {
        return view('pages.cart');
    });
    Route::get('/checkout', function () {
        return view('pages.checkout');
    });
});


Route::middleware(['auth', 'role'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard');
        })->name('admin.dashboard');

        Route::get('/charts', function () {
            return view('admin.pages.charts');
        })->name('admin.charts');

        Route::get('/tables', function () {
            return view('admin.pages.tables');
        })->name('admin.tables');
    });
});
