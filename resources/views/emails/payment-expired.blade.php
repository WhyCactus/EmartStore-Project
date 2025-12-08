@extends('emails.layouts.app')

@section('title', 'Payment Expired - Order Cancelled')
@section('container-class', 'wide')
@section('header-class', 'red')

@section('icon', '❌')
@section('header-title', 'Payment Expired')
@section('header-subtitle', now()->format('F d, Y - H:i'))

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Dear <strong>{{ $order->user->username }}</strong>,</p>

    <div style="background: #f8d7da; border-left: 4px solid #dc3545; padding: 15px; margin: 20px 0; border-radius: 4px;">
        <p style="margin: 0; color: #721c24; font-size: 16px;">
            <strong>⏰ Payment Time Expired</strong>
        </p>
        <p style="margin: 10px 0 0 0; color: #721c24;">
            We regret to inform you that your payment for order <strong>{{ $order->order_code }}</strong> has expired due to non-completion within the 30-minute time frame.
        </p>
    </div>

    <div class="summary">
        <h2>📋 Cancelled Order Details</h2>
        <div class="stat-row">
            <span class="stat-label">📦 Order Code:</span>
            <span class="stat-value urgent">{{ $order->order_code }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">📅 Order Date:</span>
            <span class="stat-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">❌ Cancelled At:</span>
            <span class="stat-value">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">💰 Order Amount:</span>
            <span class="stat-value" style="font-size: 20px; color: #dc3545; font-weight: bold;">${{ number_format($order->total_price, 2) }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">💳 Payment Method:</span>
            <span class="stat-value">{{ ucfirst($order->payment_method) }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">📊 Status:</span>
            <span class="stat-value" style="color: #dc3545;"><strong>CANCELLED</strong></span>
        </div>
    </div>

    <div style="background: #fff3cd; border-radius: 4px; padding: 15px; margin: 20px 0;">
        <p style="margin: 0; color: #856404;">
            <strong>ℹ️ What happens next?</strong>
        </p>
        <ul style="margin: 10px 0 0 0; color: #856404;">
            <li>Your order has been automatically cancelled</li>
            <li>No charges were made to your account</li>
            <li>Product inventory has been released</li>
        </ul>
    </div>

    <p><strong>Want to complete your purchase?</strong></p>
    <p>If you still wish to purchase these items, please visit our website and place a new order. Don't worry, the items are still available!</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/') }}" class="button" style="background: #28a745; color: white; padding: 15px 40px; text-decoration: none; border-radius: 5px; font-size: 18px; font-weight: bold; display: inline-block;">
            🛒 Shop Now
        </a>
    </div>

    <p>If you have any questions or concerns, please don't hesitate to contact our support team.</p>
    <p>Best regards,<br><strong>Emart Store Team</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection

@section('footer-subtitle', 'Your payment has expired')
