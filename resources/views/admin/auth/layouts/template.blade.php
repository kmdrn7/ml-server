<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ config('app.name') }} Admin Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ backend('css/app.css') }}">
    <link rel="stylesheet" href="{{ backend('css/vendor-fontawesome-free.css') }}">
</head>
<body class="layout-login-centered-boxed">
    @yield('content')
    <!-- General JS Scripts -->
    <script src="{{ backend('vendor/jquery.min.js') }}"></script>
    <script src="{{ backend('vendor/popper.min.js') }}"></script>
    <script src="{{ backend('vendor/bootstrap.min.js') }}"></script>
</body>
</html>