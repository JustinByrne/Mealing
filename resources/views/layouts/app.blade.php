<!DOCTYPE html>
<html>
    <head>
        @include('layouts.head')
    </head>

    <body class="antialiased bg-blueGray-800">
        @include('layouts.navigation')
        @yield('content')
    </body>
</html>