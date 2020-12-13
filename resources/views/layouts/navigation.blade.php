<header class="flex items-center bg-gray-800 px-8 flex-wrap" x-data="{ nav: false }">
    <a href="#" class="px-3 py-5 mr-4 inline-flex intems-center">
        <span class="text-xl text-white font-bold tracking-wide">
            Mealing
        </span>
    </a>
    <button class="text-white inline-flex p-3 rounded ml-auto hover:bg-gray-900 md:hidden" @click.prevent="nav = !nav">
        <i x-show="!nav" class="fas fa-bars"></i>
        <i x-show="nav" class="fas fa-times"></i>
    </button>
    <div class="w-full md:inline-flex md:flex-grow md:w-auto" :class="{ 'hidden': !nav }">
        <nav class="flex flex-col md:inline-flex md:flex-row md:ml-auto">
            @auth
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard*')">Dashboard</x-nav-link>
                <x-nav-link href="#" :active="request()->routeIs('menu*')">Menus</x-nav-link>
                <x-nav-link href="{{ route('meals.index') }}" :active="request()->routeIs('meal*')">Meals</x-nav-link>
                <x-nav-link href="{{ route('ingredients.index') }}" :active="request()->routeIs('ingredient*')">Ingredients</x-nav-link>

                <div class="relative px-2 hidden md:block" x-data="{ userShow: false }" @click.away="userShow = false" @keydown.escape.window="userShow = false">
                    <div class="py-3">
                        <button class="relative z-10 block focus:outline-none" @click.prevent="userShow = !userShow" aria-expanded="userShow ? 'true' : 'false'" :class="{ 'active': 'userShow' }">
                            <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-orange-300" src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}">
                        </button>
                    </div>
                    <div class="right-0 bg-gray-100 border-2 border-blueGray-700 rounded py-2 text-gray-600 mt-3 shadow-xl lg:w-56 lg:absolute" x-show.transition.opacity.duration.300ms="userShow">
                        <x-user-nav-link href="#">Profile</x-user-nav-link>
                        <x-user-nav-link href="#">Settings</x-user-nav-link>
                        <x-user-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</x-user-nav-link>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="w-full md:hidden">
                    <div class="py-3 px-2">
                        <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-orange-300" src="{{ Auth::user()->getAvatar() }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="flex flex-col">
                        <x-nav-link href="#">Profile</x-nav-link>
                        <x-nav-link href="#">Settings</x-nav-link>
                        <x-nav-link href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log Out
                        </x-nav-link>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <x-nav-link href="{{ route('login') }}">Login</x-nav-link>
                <x-nav-link href="{{ route('register') }}">Register</x-nav-link>
            @endauth
        </nav>
    </div>
</header>