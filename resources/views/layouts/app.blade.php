<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Mealing is an application that allows you to create menus using lists of recipes from the community">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icons.css') }}" rel="stylesheet" >
        @livewireStyles
        <script src="https://kit.fontawesome.com/a357069ed8.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <title>@if (trim($__env->yieldContent('title'))) @yield('title') | @endif Mealing</title>
        @livewireScripts
        <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    </head>

    <body>
        <div class="w-full min-h-screen flex flex-col lg:flex-row bg-gray-100 dark:bg-gray-800">
            <!-- Header -->
            <header>
                @include('layouts.header')
            </header>
            <main class="p-4 lg:p-6 w-full lg:ml-72">
                <!-- Search Bar -->
                <div class="flex flex-col lg:flex-row justify-between mb-4">
                    <div>
                        <form action="{{ route('search') }}" method="GET">
                            <div class="relative">
                                <button type="submit" class="absolute p-3 bg-green-700 bg-opacity-20 rounded-lg text-center text-green-700 dark:bg-opacity-30">
                                    <i class="fas fa-search"></i>
                                </button>
                                <input class="w-full lg:max-w-xs pl-12 py-3 border-0 bg-green-700 bg-opacity-10 rounded-lg placeholder-gray-400 dark:bg-opacity-30 dark:text-gray-200" type="text" placeholder="Search..." name="s">
                            </div>
                        </form>
                    </div>
                    <div class="hidden lg:block text-right relative" x-data="{ open: false }" @click.away="open = false">
                        <div class="text-gray-600 flex items-center space-x-2 cursor-pointer dark:text-gray-200" @click="open = !open">
                            <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-orange-300" src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}">
                            <p>
                                {{ Auth::user()->name }}
                            </p>
                            <button class="px-1.5" aria-label="Profile Menu">
                                <i
                                    class="fas fa-angle-down transform duration-300 ease-in-out"
                                    :class="{ 'rotate-180': open }"
                                ></i>
                            </button>
                        </div>
                        <div
                            class="absolute right-0 z-10"
                            x-cloak
                            x-show.transition.opacity.duration.350ms="open"
                        >
                            <div class="w-52 shadow-md rounded-md mt-1 py-2 bg-white text-left flex flex-col dark:bg-gray-700 dark:text-gray-200">
                                <a href="{{ route('profile') }}" class="px-5 py-2 hover:bg-green-700 hover:text-white">
                                    Profile
                                </a>
                                <a href="{{ route('profile.settings.account') }}" class="px-5 py-2 hover:bg-green-700 hover:text-white">
                                    Settings
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-5 py-2 hover:bg-green-700 hover:text-white" aria-label="Logout">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <div class="w-full">
                    @yield('content')
                </div>
            </main>
        </div>
        @yield('scripts')
        @if (! is_null(config('app.google_analytics')))
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_analytics') }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());

                gtag('config', '{{ config('app.google_analytics') }}');
            </script>
        @endif
    </body>
</html>