@section('side-links')
    <x-links.sidebar href="{{ route('ingredients.create') }}" :active="request()->routeIs('ingredients.create')">
        Create New Ingredient
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('ingredients.index') }}" :active="request()->routeIs('ingredients.index')">
        My Ingredients
    </x-links.sidebar>
    <x-links.sidebar href="{{ route('ingredients.all') }}" :active="request()->routeIs('ingredients.all')">
        All Ingredients
    </x-links.sidebar>
@endsection