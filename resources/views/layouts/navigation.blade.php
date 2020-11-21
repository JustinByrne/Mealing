<header class="flex items-center bg-gray-800 px-8 flex-wrap">
    <a href="#" class="px-3 py-2 mr-4 inline-flex intems-center">
        <span class="text-xl text-white font-bold tracking-wide">
            Mealing
        </span>
    </a>
    <button class="text-white inline-flex p-3 rounded ml-auto hover:bg-gray-900 lg:hidden navToggler" data-toggle="#navLinks">
        <i class="fas fa-bars"></i>
    </button>
    <div class="hidden w-full lg:inline-flex lg:flex-grow lg:w-auto" id="navLinks">
        <nav class="flex flex-col lg:inline-flex lg:flex-row lg:ml-auto">
            @auth
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard*')">Dashboard</x-nav-link>
                <x-nav-link href="#" :active="request()->routeIs('menu*')">Menus</x-nav-link>
                <x-nav-link href="{{ route('meals.index') }}" :active="request()->routeIs('meal*')">Meals</x-nav-link>
                <x-nav-link href="{{ route('ingredients.index') }}" :active="request()->routeIs('ingredient*')">Ingredients</x-nav-link>

                <div class="relative px-2">
                    <div class="pt-3">
                        <button class="block navToggler focus:outline-none" data-toggle="#userLinks" id="btnUserLinks">
                            <img
                                class="rounded-full w-10 h-10 border-2 border-transparent hover:border-orange-300"
                                src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=40"
                                alt="{{ Auth::user()->name }}"
                            >
                        </button>
                    </div>
                    <div class="hidden right-0 bg-gray-100 rounded py-2 text-gray-600 mt-3 shadow-xl lg:w-56 lg:absolute" id="userLinks">
                        <x-user-nav-link href="#">Profile</x-user-nav-link>
                        <x-user-nav-link href="#">Settings</x-user-nav-link>
                        <x-user-nav-link href="{{ route('logout') }}">Log Out</x-user-nav-link>
                    </div>
                </div>
            @else
                <x-nav-link href="{{ route('login') }}">Login</x-nav-link>
                <x-nav-link href="{{ route('register') }}">Register</x-nav-link>
            @endauth
        </nav>
    </div>
</header>

@section('scripts')
<script type="text/javascript">
    $('.navToggler').click(function()  {
        var toggle = $(this).data('toggle');
        $(toggle).toggleClass('hidden');
    });
</script>
@endsection