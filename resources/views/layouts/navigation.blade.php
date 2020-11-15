<header class="lg:px-16 px-6 bg-white items-center lg:py-0 py-2 mb-5">
    <div class="container mx-auto flex flex-wrap">
        <div class="flex-1 flex justify-between items-center">
            <a href="#">
                Mealing
            </a>
        </div>

        <label for="menu-toggle" class="cursor-pointer lg:hidden block"><svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><title>menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg></label>
        <input class="hidden" type="checkbox" id="menu-toggle" />

        <div class="hidden lg:flex lg:items-center lg:w-auto w-full" id="menu">
            <nav class="lg:mb-0 mb-2">
                <ul class="lg:flex items-center justify-between text-base text-gray-700 pt-4 lg:pt-0">
                    @auth
                        <li>
                            <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                                {{ __('Home') }}
                            </x-nav-link>
                        </li>
                    @else
                        <li>
                            <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                                {{ __('Login') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                                {{ __('Register') }}
                            </x-nav-link>
                        </li>
                    @endif
                </ul>
            </nav>

            @auth
                <a href="#" class="lg:ml-4 flex items-center justify-start lg:mb-0 mb-4 pointer-cursor">
                    <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-indigo-400" src="https://pbs.twimg.com/profile_images/1128143121475342337/e8tkhRaz_normal.jpg" alt="Andy Leverenz">
                </a>
            @endif
        </div>
    </div>
</header>