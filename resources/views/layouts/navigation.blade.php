<header class="lg:px-16 px-6 bg-gray-800 items-center lg:py-0 py-2 mb-5">
    <div class="container mx-auto flex flex-wrap">
        <div class="flex-1 flex justify-between items-center text-base text-gray-300">Mealing</div>
        <label for="menu-toggle" class="cursor-pointer lg:hidden block"><svg class="fill-current text-gray-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><title>menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path></svg></label>
        <input class="hidden" type="checkbox" id="menu-toggle" />
        <div class="hidden lg:flex lg:items-center lg:w-auto w-full" id="menu">
            <nav class="lg:mb-0 mb-2">
                <ul class="lg:flex items-center justify-between text-base text-gray-300 pt-4 lg:pt-0">
                    @auth
                        <li>
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('logout') }}">
                                {{ __('Logout') }}
                            </x-nav-link>
                        </li>
                    @else
                        <li>
                            <x-nav-link href="{{ route('login') }}">
                                {{ __('Login') }}
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="{{ route('register') }}">
                                {{ __('Register') }}
                            </x-nav-link>
                        </li>
                    @endif
                </ul>
            </nav>
            @auth
                <div href="#" class="lg:ml-4 flex items-center justify-start lg:mb-0 mb-4 pointer-cursor">
                    <img
                        class="rounded-full w-10 h-10 border-2 border-transparent hover:border-indigo-400"
                        src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=40"
                        alt="{{ Auth::user()->name }}"
                    >
                </div>
            @endif
        </div>
    </div>
</header>