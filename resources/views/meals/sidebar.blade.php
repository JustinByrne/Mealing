@section('side-links')
    <x-links.sidebar href="{{ route('meals.create') }}" :active="request()->routeIs('meals.create')">
        Create new Meal
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('meals.index') }}" :active="request()->routeIs('meals.index')">
        My Meals
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('meals.all') }}" :active="request()->routeIs('meals.all')">
        All Meals
    </x-links.sidebar>
@endsection