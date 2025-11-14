<?php

use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.dashboard');

    //USER
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::put('/user/{id}', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');

    //PRODUCT
    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('products');
        Route::get('/create-product', [AdminProductController::class, 'create'])->name('create-product');
        Route::post('/create-product', [AdminProductController::class, 'store'])->name('store-product');
        Route::get('/edit-product/{id}', [AdminProductController::class, 'edit'])->name('edit-product');
        Route::put('/edit-product/{id}', [AdminProductController::class, 'update'])->name('update-product');
        Route::delete('/delete-product/{id}', [AdminProductController::class, 'destroy'])->name('delete-product');
    });

    //CATEGORY
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('categories');
        Route::get('/create-category', [AdminCategoryController::class, 'create'])->name('create-category');
        Route::post('/create-category', [AdminCategoryController::class, 'store'])->name('store-category');
        Route::get('/edit-category/{id}', [AdminCategoryController::class, 'edit'])->name('edit-category');
        Route::put('/edit-category/{id}', [AdminCategoryController::class, 'update'])->name('update-category');
        Route::put('/category/{id}', [AdminCategoryController::class, 'toggleStatus'])->name('toggle-status');
    });

    //BRAND
    Route::prefix('brand')->name('brand.')->group(function () {
        Route::get('/', [AdminBrandController::class, 'index'])->name('brands');
        Route::get('/create-brand', [AdminBrandController::class, 'create'])->name('create-brand');
        Route::post('/create-brand', [AdminBrandController::class, 'store'])->name('store-brand');
        Route::get('/edit-brand/{id}', [AdminBrandController::class, 'edit'])->name('edit-brand');
        Route::put('/edit-brand/{id}', [AdminBrandController::class, 'update'])->name('update-brand');
        Route::put('/brand/{id}', [AdminBrandController::class, 'toggleStatus'])->name('toggle-status');
    });

    //ORDER
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [AdminOrderController::class, 'detail'])->name('order-detail');
    Route::put('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
});
