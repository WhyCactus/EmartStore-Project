@extends('emails.layouts.app')

@section('title', 'Password Reset')
@section('header-class', 'pink')

@section('icon', '🔐')
@section('header-title', 'Password Reset Request')
@section('header-subtitle', 'Reset your password securely')

@section('header')
    @include('emails.layouts.header')
@endsection

@section('content')
    <p>Hello!</p>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <div class="alert-box">
        <p>
            <strong>⏱️ Time Sensitive:</strong> This password reset link will expire in 60 minutes.
        </p>
    </div>

    <div class="text-center m-30-0">
        <a href="{{ $resetUrl }}" class="button pink">
            Reset Password
        </a>
    </div>

    <div class="warning-box">
        <p>
            <strong>⚠️ Security Notice:</strong><br>
            If you did not request a password reset, please ignore this email. Your password will remain unchanged and no further action is required.
        </p>
    </div>

    <div class="info-box">
        <h3>What happens next?</h3>
        <p class="with-margin">
            <strong>1.</strong> Click the "Reset Password" button above<br>
            <strong>2.</strong> Enter your new password<br>
            <strong>3.</strong> Confirm the change<br>
            <strong>4.</strong> Log in with your new password
        </p>
    </div>

    <div class="link-box">
        <p>
            Having trouble clicking the button? Copy and paste this URL into your browser:
        </p>
        {{ $resetUrl }}
    </div>

    <p class="mt-30">
        If you have any questions or concerns, please don't hesitate to contact our support team.
    </p>

    <p>
        Best regards,<br>
        <strong>The Emart Team</strong>
    </p>
@endsection

@section('footer')
    @include('emails.layouts.footer')
@endsection

@section('footer-subtitle', 'Your account security is our priority')
