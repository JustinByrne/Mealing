@section('side-links')
    <x-side-link href="{{ route('meals.create') }}" :active="request()->routeIs('meals.create')">
        Create new Meal
    </x-side-link>
    <x-side-link href="{{ route('meals.index') }}" :active="request()->routeIs('meals.index')">
        My Meals
    </x-side-link>
    <x-side-link href="{{ route('meals.all') }}" :active="request()->routeIs('meals.all')">
        All Meals
    </x-side-link>
@endsection