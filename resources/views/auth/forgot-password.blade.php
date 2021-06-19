@extends('auth.layout')

@section('title', 'Forgotten Password')

@section('content')
<div class="p-3 space-y-3">
    @if (session('status'))
        <div class="bg-blue-400 bg-opacity-20 text-blue-700 border-l-4 border-blue-400 py-3 px-4 dark:bg-opacity-40 dark:text-blue-300">
            <i class="fas fa-info-circle mr-1"></i> {{ session('status') }}
        </div>
    @endif
    
    <div class="text-center">
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label for="email" class="hidden lg:block dark:text-gray-200">
                        Email
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input type="email" placeholder="Email" id="email" name="email" value="{{ old('email') }}" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                    @error('email')
                        <p class="text-red-500 italic text-xs font-light">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="md:flex md:items-center">
                <div class="md:w-1/3"></div>
                <div>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                        Send link
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection