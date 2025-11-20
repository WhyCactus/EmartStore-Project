<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Emart Store')</title>
    <link rel="stylesheet" href="{{ asset('css/mails.css') }}">
    <style>
        /* Theme-specific overrides */
        @yield('additional-styles')
    </style>
</head>

<body>
    <div class="email-container @yield('container-class')">
        @yield('header')

        <div class="content">
            @yield('content')
        </div>

        @yield('footer')
    </div>
</body>

</html>
