<!DOCTYPE html>
<html>

<head>
    <title>Confirm Account</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Account Confirmation</h1>
            <p>Reporting time: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
        </div>

        <div class="body">
            <p>Hello {{ $user->name }},</p>
            <p>Thank you for registering with us. Your account has been successfully created.</p>
            <p>Please click the link below to confirm your account:</p>
            <p><a href="#">Confirm Account</a></p>
            <p>Best regards,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
