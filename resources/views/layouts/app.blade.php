<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Mealing | @yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            #menu-toggle:checked + #menu {
                display: block;
            }
        </style>
    </head>

    <body class="antialiased bg-gray-200">
        @include('layouts.navigation')
        @yield('content')
    </body>
</html>