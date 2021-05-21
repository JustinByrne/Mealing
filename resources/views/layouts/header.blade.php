<header class="lg:fixed">
    <div class="w-full bg-green-600 p-3 text-white lg:w-72 lg:h-screen" x-data="{open: false}">
        <div class="flex justify-between items-center lg:mb-20 lg:mt-10">
            <div class="flex text-lg font-bold lg:text-center lg:w-full lg:flex-col">
                <i class="fas fa-pizza-slice pr-3 self-center lg:pr-0 lg:text-3xl lg:pb-3"></i>
                Mealing
            </div>
            <div class="text-lg lg:hidden">
                <button class="border border-gray-100 px-2 rounded-lg duration-300 ease-in-out transition text-center hover:bg-white hover:text-green-600" @click="open = !open">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="hidden lg:block mt-3" x-bind:class="{'hidden': !open}" @click.away="open = false">
            <nav class="flex flex-col">
                <a
                    href="{{ route('homepage') }}"
                    @if (request()->routeIs('homepage*'))
                        class="w-full p-3 mb-3 font-bold text-green-600 bg-white rounded-lg space-x-2"
                    @else
                        class="w-full p-3 mb-3 font-bold rounded-lg hover:bg-white hover:text-green-600 space-x-2"
                    @endif
                >
                    <i class="fas fa-home"></i>
                    <span>
                        Home
                    </span>
                </a>
                <a
                    href="{{ route('menu.index') }}"
                    @if (request()->routeIs('menu*'))
                        class="w-full p-3 mb-3 font-bold text-green-600 bg-white rounded-lg space-x-2"
                    @else
                        class="w-full p-3 mb-3 font-bold rounded-lg hover:bg-white hover:text-green-600 space-x-2"
                    @endif
                >
                    <i class="fas fa-utensils"></i>
                    <span>
                        Menus
                    </span>
                </a>
                <a
                    href="{{ route('meals.index') }}"
                    @if (request()->routeIs('meals*'))
                        class="w-full p-3 mb-3 font-bold text-green-600 bg-white rounded-lg space-x-2"
                    @else
                        class="w-full p-3 mb-3 font-bold rounded-lg hover:bg-white hover:text-green-600 space-x-2"
                    @endif
                >
                    <i class="fas fa-hamburger"></i>
                    <span>
                        Meals
                    </span>
                </a>
                @if (request()->routeIs('meals*'))
                    <a
                        href="{{ route('meals.create') }}"
                        @if (request()->routeIs('meals.create'))
                            class="w-full py-2 pl-8 pr-3 mb-3 font-bold text-green-600 bg-white rounded-lg space-x-2"
                        @else
                            class="w-full py-2 pl-8 pr-3 mb-3 font-bold rounded-lg hover:bg-white hover:text-green-600 space-x-2"
                        @endif
                    >
                        <i class="fas fa-plus"></i>
                        <span>
                            Create Meal
                        </span>
                    </a>
                @endif
                @can ('admin_access')
                    <a
                        href="{{ route('admin.dashboard') }}"
                        @if (request()->routeIs('admin*'))
                            class="w-full p-3 mb-3 font-bold text-green-600 bg-white rounded-lg space-x-2"
                        @else
                            class="w-full p-3 mb-3 font-bold rounded-lg hover:bg-white hover:text-green-600 space-x-2"
                        @endif
                    >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>
                            Admin
                        </span>
                    </a>
                @endcan
            </nav>
            <div class="w-full font-bold lg:hidden" x-data="{ open: false }" @click.away="open = false">
                <div class="flex justify-between p-3 items-center" @click="open = !open">
                    <p>
                        {{ Auth::user()->name }}
                    </p>
                    <button>
                        <i
                            class="fas text-center cursor-pointer"
                            :class="{ 'fa-angle-down': !open, 'fa-angle-up': open }"
                        ></i>
                    </button>
                </div>
                <div class="w-full font-bold text-green-600 bg-white rounded-lg space-x-2" :class="{ 'hidden': !open }">
                    <div class="flex flex-col text-left">
                        <a href="{{ route('profile') }}" class="px-3 py-2">
                            Profile
                        </a>
                        <a href="{{ route('profile.settings.account') }}" class="px-3 py-2">
                            Settings
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 font-bold w-full text-left">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
