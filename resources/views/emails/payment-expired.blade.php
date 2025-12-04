@extends('emails.layouts.app')

@section('title', 'Payment Expired Notification')
@section('container-class', 'wide')
@section('header-class', 'red')

@section('icon', '⏰')
@section('header-title', 'Payment Expired')
@section('header-subtitle', now()->format('F d, Y - H:i'))

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Dear {{ $order->user->username }},</p>
    <p>We regret to inform you that your payment for order <strong>{{ $order->order_code }}</strong> has expired due to
        non-completion within the allotted time frame.</p>

    <div class="summary">
        <h2>📋 Order Summary</h2>
        <div class="stat-row">
            <span class="stat-label">Order Code:</span>
            <span class="stat-value urgent">{{ $order->order_code }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">Order Date:</span>
            <span class="stat-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">Total Amount:</span>
            <span class="stat-value">${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <p>Unfortunately, since the payment was not completed in time, your order has been cancelled. If you still wish to
        purchase the items, please place a new order through our website.</p>

    <p>Best regards,<br><strong>Emart System</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection

@section('footer-subtitle', 'Your payment has expired')
