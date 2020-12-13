<!DOCTYPE html>
<html>
    <head>
        @include('layouts.head')
    </head>

    <body class="antialiased bg-blueGray-600">
        @include('layouts.navigation')
        <div class="container w-full flex flex-wrap mx-auto mt-6 lg:mt-12">
            <div class="w-full ml-5 lg:ml-0 lg:w-1/5 lg:px-6 text-xl text-gray-800 leading-normal">    
                <p class="text-base font-bold py-2 lg:pb-6 text-white">
                    @if (trim($__env->yieldContent('side-links'))) Menu @endif
                </p>
                <div class="w-full sticky inset-0 overflow-x-hidden overflow-y-auto mt-0 z-20 lg:overflow-y-hidden lg:block">
                    <ul class="list-reset">
                        @yield('side-links')
                    </ul>
                </div>
            </div>
            @if (trim($__env->yieldContent('content')))
                <div class="w-full p-8 my-6 text-gray-900 leading-normal shadow-lg bg-white rounded lg:mt-0 lg:w-4/5">
                    @yield('content')
                </div>
            @endif
        </div>
        @livewireScripts
    </body>
</html>