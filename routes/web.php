<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/my-account', function () {
    return view('pages.my-account');
});

Route::get('/product-list', function () {
    return view('pages.product-list');
});

Route::get('/product-detail', function () {
    return view('pages.product-detail');
});

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
