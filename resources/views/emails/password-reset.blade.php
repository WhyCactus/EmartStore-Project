<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <h2>Hello!</h2>

    <p>You are receiving this email because we received a password reset request for your account.</p>

    <p>
        <a href="{{ $resetUrl }}"
            style="background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Reset Password
        </a>
    </p>

    <p>This password reset link will expire in 60 minutes.</p>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Regards,<br>{{ config('app.name') }}</p>

    <hr>
    <p style="color: #666; font-size: 12px;">
        If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
        browser:
        <br>{{ $resetUrl }}
    </p>
</body>

</html>
