<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="/css/app.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a357069ed8.js" crossorigin="anonymous"></script>
        <script src="/js/app.js" defer></script>
        <title>Mealing Login</title>
    </head>

    <body>
        <div class="w-full h-screen flex items-center justify-center p-4 bg-gray-100 dark:bg-gray-800">
            <div class="w-full lg:max-w-md rounded-md shadow-md bg-white dark:bg-gray-700">
                <div class="w-full p-4 border-b border-gray-200 text-center dark:text-gray-200">
                    <i class="fas fa-pizza-slice self-center text-3xl pb-3"></i>
                    <p class="font-bold">
                        Mealing Login
                    </p>
                </div>
                <form action="/login" method="POST" class="p-3 space-y-3">
                    @csrf
                    @if (session('message'))
                        <div class="bg-red-400 bg-opacity-20 text-red-700 border-l-4 border-red-400 py-3 px-4 dark:bg-opacity-40 dark:text-red-300">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('message') }}
                        </div>
                    @endif
                    @error('email')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
                        <label for="email" class="hidden lg:block dark:text-gray-200">
                            Email
                        </label>
                        <input type="email" placeholder="Email" id="email" name="email" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 items-center">
                        <label for="password" class="hidden lg:block dark:text-gray-200">
                            Password
                        </label>
                        <input type="password" placeholder="Password" id="password" name="password" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 lg:gap-3 items-center">
                        <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                            Login
                        </button>
                        <a href="#" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-gray-400 text-white hover:bg-gray-300 text-center">
                            Register
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>