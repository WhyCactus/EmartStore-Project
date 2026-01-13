<?php

use App\Http\Controllers\AdminBrandController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:admin|staff']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => ['can:user']], function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('users');
        Route::put('/user/{id}', [AdminUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('user-export', [AdminUserController::class, 'export'])->name('user-export');
        Route::post('user-import', [AdminUserController::class, 'import'])->name('user-import');
        Route::get('/create-user', [AdminUserController::class, 'create'])->name('create-user');
        Route::post('/create-user', [AdminUserController::class, 'store'])->name('store-user');
        Route::get('/edit-user/{id}', [AdminUserController::class, 'edit'])->name('edit-user');
        Route::put('/edit-user/{id}', [AdminUserController::class, 'update'])->name('update-user');
    });

    Route::group(['middleware' => ['can:product']], function () {
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('products');
            Route::get('/create-product', [AdminProductController::class, 'create'])->name('create-product');
            Route::post('/create-product', [AdminProductController::class, 'store'])->name('store-product');
            Route::get('/edit-product/{id}', [AdminProductController::class, 'edit'])->name('edit-product');
            Route::put('/edit-product/{id}', [AdminProductController::class, 'update'])->name('update-product');
            Route::delete('/delete-product/{id}', [AdminProductController::class, 'destroy'])->name('delete-product');
        });
    });

    Route::group(['middleware' => ['can:category']], function () {
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [AdminCategoryController::class, 'index'])->name('categories');
            Route::get('/create-category', [AdminCategoryController::class, 'create'])->name('create-category');
            Route::post('/create-category', [AdminCategoryController::class, 'store'])->name('store-category');
            Route::get('/edit-category/{id}', [AdminCategoryController::class, 'edit'])->name('edit-category');
            Route::put('/edit-category/{id}', [AdminCategoryController::class, 'update'])->name('update-category');
            Route::put('/category/{id}', [AdminCategoryController::class, 'toggleStatus'])->name('toggle-status');
        });
    });

    Route::group(['middleware' => ['can:brand']], function () {
        Route::prefix('brand')->name('brand.')->group(function () {
            Route::get('/', [AdminBrandController::class, 'index'])->name('brands');
            Route::get('/create-brand', [AdminBrandController::class, 'create'])->name('create-brand');
            Route::post('/create-brand', [AdminBrandController::class, 'store'])->name('store-brand');
            Route::get('/edit-brand/{id}', [AdminBrandController::class, 'edit'])->name('edit-brand');
            Route::put('/edit-brand/{id}', [AdminBrandController::class, 'update'])->name('update-brand');
            Route::put('/brand/{id}', [AdminBrandController::class, 'toggleStatus'])->name('toggle-status');
        });
    });

    Route::group(['middleware' => ['can:order']], function () {
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'detail'])->name('order-detail');
        Route::put('/orders/{id}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
    });

    Route::group(['middleware' => ['can:role']], function () {
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create-role', [RoleController::class, 'create'])->name('create-role');
            Route::post('/create-role', [RoleController::class, 'store'])->name('store-role');
            Route::get('/edit-role/{id}', [RoleController::class, 'edit'])->name('edit-role');
            Route::put('/edit-role/{id}', [RoleController::class, 'update'])->name('update-role');
            Route::delete('/delete-role/{id}', [RoleController::class, 'destroy'])->name('delete-role');
        });
    });

    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [AdminChatController::class, 'sendMessage'])->name('chat-send');
});
