@extends('emails.layouts.app')

@section('title', 'Payment Reminder - Complete Your Purchase')
@section('container-class', 'wide')
@section('header-class', 'orange')

@section('icon', '⚠️')
@section('header-title', 'Payment Reminder')
@section('header-subtitle', now()->format('F d, Y - H:i'))

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Dear <strong>{{ $order->user->username }}</strong>,</p>
    <p>⏰ Your payment for Order <strong>{{ $order->order_code }}</strong> is about to expire!</p>

    <div style="background: #fff3cd; border-left: 4px solid #ff9800; padding: 15px; margin: 20px 0; border-radius: 4px;">
        <p style="margin: 0; color: #856404; font-size: 16px;">
            <strong>⏳ Time Remaining: {{ $minutesRemaining }} minute(s)</strong>
        </p>
        <p style="margin: 10px 0 0 0; color: #856404;">
            Please complete your payment within the next {{ $minutesRemaining }} minute(s) to secure your order.
        </p>
    </div>

    <div class="summary">
        <h2>📋 Order Details</h2>
        <div class="stat-row">
            <span class="stat-label">📦 Order Code:</span>
            <span class="stat-value urgent">{{ $order->order_code }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">📅 Order Date:</span>
            <span class="stat-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">💰 Total Amount:</span>
            <span class="stat-value" style="font-size: 20px; color: #ff9800; font-weight: bold;">${{ number_format($order->total_price, 2) }}</span>
        </div>
        <div class="stat-row">
            <span class="stat-label">💳 Payment Method:</span>
            <span class="stat-value">{{ ucfirst($order->payment_method) }}</span>
        </div>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $paymentUrl }}" class="button" style="background: #ff9800; color: white; padding: 15px 40px; text-decoration: none; border-radius: 5px; font-size: 18px; font-weight: bold; display: inline-block;">
            💳 Complete Payment Now
        </a>
    </div>

    <div style="background: #f8f9fa; border-radius: 4px; padding: 15px; margin: 20px 0;">
        <p style="margin: 0; color: #6c757d; font-size: 14px;">
            <strong>⚠️ Important:</strong> If payment is not completed within 30 minutes of order creation, your order will be automatically cancelled.
        </p>
    </div>

    <p>If you have any questions, please don't hesitate to contact our support team.</p>
    <p>Best regards,<br><strong>Emart Store Team</strong></p>
@endsection
