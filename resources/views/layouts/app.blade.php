<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="/css/app.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a357069ed8.js" crossorigin="anonymous"></script>
        <script src="/js/app.js" defer></script>
        <title>Layout</title>
    </head>

    <body>
        <div class="w-full min-h-screen flex flex-col lg:flex-row bg-gray-100 dark:bg-gray-800">
            <!-- Header -->
            @include('layouts.header')
            <div class="p-4 lg:p-6 w-full lg:ml-72">
                <!-- Search Bar -->
                <div class="flex flex-col lg:flex-row justify-between mb-4">
                    <form action="" method="POST">
                        <div class="relative">
                            <button type="submit" class="absolute p-3 bg-green-600 bg-opacity-20 rounded-lg text-center text-green-600 dark:bg-opacity-30">
                                <i class="fas fa-search"></i>
                            </button>
                            <input class="w-full max-w-xs pl-12 py-3 border-0 bg-green-600 bg-opacity-10 rounded-lg placeholder-gray-400 dark:bg-opacity-30 dark:text-gray-200" type="text" placeholder="Search..." name="s">
                        </div>
                    </form>
                    <div class="hidden lg:block text-right relative" x-data="{ open: false }" @click.away="open = false">
                        <div class="text-gray-600 flex items-center space-x-2 cursor-pointer dark:text-gray-200" @click="open = !open">
                            <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-orange-300" src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}">
                            <p>
                                {{ Auth::user()->name }}
                            </p>
                            <button class="px-1.5">
                                <i
                                    class="fas"
                                    :class="{ 'fa-angle-down': !open, 'fa-angle-up': open }"
                                ></i>
                            </button>
                        </div>
                        <div class="absolute right-0 z-10" :class="{ 'hidden': !open }">
                            <div class="w-52 shadow-md rounded-md mt-1 py-2 bg-white text-left flex flex-col dark:bg-gray-700 dark:text-gray-200">
                                <a href="{{ route('profile') }}" class="px-5 py-2 hover:bg-green-600 hover:text-white">
                                    Profile
                                </a>
                                <a href="{{ route('profile.settings.account') }}" class="px-5 py-2 hover:bg-green-600 hover:text-white">
                                    Settings
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-5 py-2 hover:bg-green-600 hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <div class="w-full pb-3">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>