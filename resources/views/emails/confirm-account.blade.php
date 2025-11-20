@extends('emails.layouts.app')

@section('title', 'Account Confirmation')
@section('header-class', 'purple')

@section('icon', '👋')
@section('header-title', 'Welcome to Emart!')
@section('header-subtitle', 'Thank you for joining us')

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Hello <strong>{{ $user->name }}</strong>,</p>

    <div class="welcome-box">
        <h2>🎉 Your account has been successfully created!</h2>
        <p>We're excited to have you as part of the Emart community. To get started, please confirm your email address.</p>
    </div>

    <div class="info-box">
        <h3>Account Details</h3>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Registration Date:</strong> {{ now()->format('F d, Y - H:i') }}</p>
    </div>

    <div class="text-center m-30-0">
        <a href="#" class="button purple">Confirm Your Account</a>
    </div>

    <div class="features">
        <h3 class="purple">What you can do with your account:</h3>
        <div class="feature-item">
            <strong>🛍️ Shop Easily:</strong> Browse thousands of products and enjoy seamless shopping
        </div>
        <div class="feature-item">
            <strong>📦 Track Orders:</strong> Monitor your orders from purchase to delivery
        </div>
        <div class="feature-item">
            <strong>💝 Wishlist:</strong> Save your favorite items for later
        </div>
        <div class="feature-item">
            <strong>⭐ Reviews:</strong> Share your experience and help other shoppers
        </div>
        <div class="feature-item">
            <strong>🎁 Exclusive Offers:</strong> Get access to special deals and promotions
        </div>
    </div>

    <div class="security-notice">
        <p>
            <strong>⚠️ Security Notice:</strong><br>
            If you didn't create this account, please ignore this email or contact our support team.
        </p>
    </div>

    <p class="mt-30">Welcome aboard! We're here to make your shopping experience exceptional.</p>

    <p>Best regards,<br><strong>The Emart Team</strong></p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection

@section('footer-subtitle', 'Your trusted online shopping destination')
