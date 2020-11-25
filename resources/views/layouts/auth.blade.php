<!DOCTYPE html>
<html>
    <head>
        @include('layouts.head')
    </head>

    <body class="antialiased bg-gray-800">
        @yield('content')
        @livewireScripts
    </body>
</html>