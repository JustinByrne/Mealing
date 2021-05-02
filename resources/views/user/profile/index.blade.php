@extends('layouts.app')

@section('content')
<div class="bg-white rounded-md dark:bg-gray-700">
    <div class="w-full p-4 border-b border-gray-200 ">
        <p class="font-bold dark:text-gray-200">
            User Profile
        </p>
    </div>
    <div class="p-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 w-full">
            <div class="col-span-full mb-4 lg:mb-0 lg:col-span-1">
                <img class="rounded-full mx-auto shadow-lg" src="{{ Auth::user()->getAvatar(300) }}" alt="{{ Auth::user()->getFullName() }}">
            </div>
            <div class="col-span-full lg:col-span-3">
                <div class="text-sm font-light leading-relaxed pt-10 mb-2 text-lightGray-800">
                    <p class="text-sm mb-5 dark:text-gray-200">
                        <strong>Name:</strong> {{ Auth::user()->getFullName() }}<br>
                        <strong>Email:</strong> {{ Auth::user()->email }}<br>
                        <strong>Subscripiton:</strong> Free
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection