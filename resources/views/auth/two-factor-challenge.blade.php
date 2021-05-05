@extends('auth.layout')

@section('content')
<div class="p-3">
    <form class="w-full" method="POST" action="{{ route('two-factor.login') }}">
        @csrf
        <div x-data="{ code: true }">
            <div x-show="code">
                <p class="mb-5 dark:text-gray-200">
                    Enter your 6 digit code from your two factor authenticator app.
                </p>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4 dark:text-gray-200" for="code">
                            Code
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input type="text" type="code" placeholder="X X X X X X"  class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                        @error('code')
                            <p class="text-red-500 text-xs italic">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="grid justify-items-end w-full pb-3">
                    <div>
                        <a class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600 cursor-pointer" @click="code = false">
                            Use Recovery Code
                        </a>
                    </div>
                </div>
            </div>

            <div x-show="!code">
                <p class="mb-5 dark:text-gray-200">
                    Enter your recovery code.
                </p>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4 dark:text-gray-200" for="code">
                            Recovery Code
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input name="recovery_code" type="text" placeholder="XXXXXXXXXX-XXXXXXXXXX" class="border-1 border-gray-100 shadow bg-opacity-20 rounded-lg placeholder-gray-500 w-full lg:w-60 focus:outline-none focus:ring-1 focus:border-green-500 focus:ring-green-500 dark:bg-gray-900 dark:border-transparent dark:text-gray-200">
                        @error('recovery_code')
                            <p class="text-red-500 text-xs italic">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="grid justify-items-end w-full pb-3">
                    <div>
                        <a class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600 cursor-pointer" @click="code = true">
                            Use Authenticator Code
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                    Authenticate
                </button>
            </div>
        </div>
    </form>
</div>
@endsection