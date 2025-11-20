@extends('emails.layouts.app')

@section('title', 'Order Confirmation')
@section('header-class', 'blue')

@section('icon', '✓')
@section('header-title', 'Order Confirmed!')
@section('header-subtitle', 'Thank you for your purchase')

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Hi <strong>{{ $customer->username }}</strong>,</p>
    <p>We're happy to let you know that we've received your order and it's being processed.</p>

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
            <span class="info-value">
                <span class="status-badge status-pending">{{ ucfirst($order->order_status) }}</span>
            </span>
        </div>
    </div>

    <div class="shipping-info">
        <strong>Shipping Information</strong><br>
        <strong>Recipient:</strong> {{ $order->recipient_name }}<br>
        <strong>Phone:</strong> {{ $order->recipient_phone }}<br>
        <strong>Address:</strong> {{ $order->recipient_address }}<br>
        @if ($shipping)
            <strong>Estimated Delivery:</strong>
            {{ $shipping->estimated_delivery_date ? $shipping->estimated_delivery_date->format('F d, Y') : 'TBA' }}
        @endif
    </div>

    <h3 class="blue">Order Items</h3>
    @include('emails.components.product-table', ['items' => $items, 'totalColumn' => 'Subtotal'])

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>${{ number_format($order->subtotal_amount, 2) }}</span>
        </div>
        <div class="total-row">
            <span>Shipping Cost:</span>
            <span>${{ number_format($shipping ? $shipping->shipping_cost : 1, 2) }}</span>
        </div>
        <div class="total-row grand-total">
            <span>Grand Total:</span>
            <span>${{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div class="text-center m-30-0">
        <a href="{{ route('my-account.order', $order->id) }}" class="button blue">View Order Details</a>
    </div>

    <div class="info-note">
        <p>
            <strong>What's Next?</strong><br>
            • We'll send you another email when your order ships<br>
            • You can track your order status in your account<br>
            • Contact us if you have any questions
        </p>
    </div>

    <p class="mt-30">If you have any questions about your order, please don't hesitate to contact us.</p>

    <p>Best regards,<br><strong>The Emart Team</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection
