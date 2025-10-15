<?php

use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
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
    Route::post('update-account', [UserController::class, 'updateAccount'])->name('update-account');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change-password');

    Route::get('/cart', function () {
        return view('pages.cart');
    });
    Route::get('/checkout', function () {
        return view('pages.checkout');
    });
});


Route::middleware(['auth', 'role'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard');
        })->name('admin.dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::get('/products', [AdminProductController::class, 'index'])->name('products');
        Route::get('/create-product', [AdminProductController::class, 'create'])->name('create-product');
        Route::post('/create-product', [AdminProductController::class, 'store'])->name('store-product');
        Route::get('/edit-product/{id}', [AdminProductController::class, 'edit'])->name('edit-product');
        Route::put('/edit-product/{id}', [AdminProductController::class, 'update'])->name('update-product');
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories');
        Route::get('/create-category', [AdminCategoryController::class, 'create'])->name('create-category');
        Route::post('/create-category', [AdminCategoryController::class, 'store'])->name('store-category');
        Route::get('/edit-category/{id}', [AdminCategoryController::class, 'edit'])->name('edit-category');
        Route::put('/edit-category/{id}', [AdminCategoryController::class, 'update'])->name('update-category');
        Route::get('/brands', [AdminBrandController::class, 'index'])->name('brands');
        Route::get('/create-brand', [AdminBrandController::class, 'create'])->name('create-brand');
        Route::post('/create-brand', [AdminBrandController::class, 'store'])->name('store-brand');
        Route::get('/edit-brand/{id}', [AdminBrandController::class, 'edit'])->name('edit-brand');
        Route::put('/edit-brand/{id}', [AdminBrandController::class, 'update'])->name('update-brand');
    });
});
