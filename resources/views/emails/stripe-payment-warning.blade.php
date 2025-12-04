@extends('emails.layouts.app')

@section('title', 'Warning: Stripe Payment')
@section('container-class', 'wide')
@section('header-class', 'orange')

@section('icon', '⏰')
@section('header-title', 'Payment Expired Alert')
@section('header-subtitle', now()->format('F d, Y - H:i'))

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Dear {{ $order->user->username }},</p>
    <p>We wanted to inform you that your payment window for Order <strong>{{ $order->order_code }}</strong> has expired.</p>

    <div class="summary">
        <h2>⏳ Payment Summary</h2>
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

    <div style="text-align: center;">
        <a href="{{ $paymentUrl }}" class="button">
            💳 Complete Payment Now
        </a>
    </div>

    <p>Best regards,<br><strong>Emart System</strong></p>
@endsection
