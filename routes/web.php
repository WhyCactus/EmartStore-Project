<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/my-account', function () {
    return view('pages.my-account');
});

Route::get('/product-list', [HomeController::class, 'list'])->name('product.list');
Route::get('/product-list/category/{id}', [HomeController::class, 'getProductByCategory'])->name('product.category');
Route::get('/product-list/brand/{id}', [HomeController::class, 'getProductByBrand'])->name('product.brand');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/cart', function () {
    return view('pages.cart');
});

Route::get('/checkout', function () {
    return view('pages.checkout');
});

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
