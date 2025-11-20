@extends('emails.layouts.app')

@section('title', 'Delivery Successful')
@section('header-class', 'green')

@section('icon', '📦')
@section('header-title', 'Delivery Successful!')
@section('header-subtitle', 'Your order has been delivered')

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Hi <strong>{{ $order->user->username }}</strong>,</p>

    <div class="success-message">
        <h2>✓ Your package has been delivered!</h2>
        <p><strong>Delivery Date:</strong> {{ $order->orderShipping->actual_delivery_date ? $order->orderShipping->actual_delivery_date->format('F d, Y - H:i') : now()->format('F d, Y - H:i') }}</p>
        <p>We hope you enjoy your purchase!</p>
    </div>

    <div class="info-box">
        <h3>Order Information</h3>
        <div class="info-row">
            <span class="info-label">Order Code:</span>
            <span class="info-value"><strong>{{ $order->order_code }}</strong></span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Date:</span>
            <span class="info-value">{{ $order->created_at->format('F d, Y - H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method:</span>
            <span class="info-value">{{ ucfirst($order->payment_method) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Status:</span>
            <span class="info-value"><span class="status-badge status-delivered">Delivered</span></span>
        </div>
    </div>

    <div class="delivery-info">
        <h3>📍 Delivery Details</h3>
        <strong>Delivered to:</strong> {{ $order->recipient_name }}<br>
        <strong>Phone:</strong> {{ $order->recipient_phone }}<br>
        <strong>Address:</strong> {{ $order->recipient_address }}<br>
        @if ($order->orderShipping)
            <strong>Shipping Method:</strong> {{ ucfirst($order->orderShipping->shipping_method) }}<br>
        @endif
    </div>

    <h3 class="green">Delivered Items</h3>
    @include('emails.components.product-table', ['items' => $order->orderDetails])

    <div class="rating-section">
        <h3>⭐ How was your experience?</h3>
        <p>We'd love to hear your feedback about the products you received.</p>
        <a href="{{ route('my-account.order', $order->id) }}" class="button orange mt-15">
            Rate Your Purchase
        </a>
    </div>

    <div class="text-center m-30-0">
        <a href="{{ route('my-account.order', $order->id) }}" class="button green">View Order Details</a>
    </div>

    <div class="info-note">
        <p>
            <strong>Need help with your order?</strong><br>
            If you have any issues with the delivered items or need to make a return,
            please contact our customer support within 7 days of delivery.
        </p>
    </div>

    <p class="mt-30">Thank you for choosing Emart! We hope to serve you again soon.</p>

    <p>Best regards,<br><strong>The Emart Team</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection
