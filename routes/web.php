<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripePaymentController;
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

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
});

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
    Route::get('/stripe', [StripePaymentController::class, 'showStripe'])->name('stripe');
    Route::post('/stripe', [StripePaymentController::class, 'processPayment'])->name('stripe.process');
    Route::get('/checkout/success/{orderCode}', [CheckOutController::class, 'checkoutSuccess'])->name('checkout.success');
});

// Test Mail Routes (Chỉ dùng trong môi trường dev)
if (config('app.env') === 'local') {
    Route::prefix('test-mail')->group(function () {
        Route::get('/stripe-warning', function () {
            $order = \App\Models\Order::where('payment_method', 'stripe')
                ->where('payment_status', 'pending')
                ->first();

            if (!$order) {
                return 'Không tìm thấy đơn hàng Stripe pending nào. Vui lòng tạo đơn hàng test trước.';
            }

            return new \App\Mail\SendStripePaymentWarnings($order, 5);
        })->name('test.mail.stripe.warning');

        Route::get('/stripe-expired', function () {
            $order = \App\Models\Order::where('payment_method', 'stripe')
                ->where('payment_status', 'pending')
                ->first();

            if (!$order) {
                return 'Không tìm thấy đơn hàng Stripe pending nào. Vui lòng tạo đơn hàng test trước.';
            }

            return new \App\Mail\SendExpiredStripePayment($order);
        })->name('test.mail.stripe.expired');

        Route::get('/send-stripe-warning/{orderId}', function ($orderId) {
            $order = \App\Models\Order::findOrFail($orderId);
            \Mail::to($order->user->email)->send(new \App\Mail\SendStripePaymentWarnings($order, 5));
            return 'Email cảnh báo đã được gửi đến: ' . $order->user->email;
        });

        Route::get('/send-stripe-expired/{orderId}', function ($orderId) {
            $order = \App\Models\Order::findOrFail($orderId);
            \Mail::to($order->user->email)->send(new \App\Mail\SendExpiredStripePayment($order));
            return 'Email hết hạn đã được gửi đến: ' . $order->user->email;
        });
    });
}
