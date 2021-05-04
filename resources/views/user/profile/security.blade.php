@extends('user.profile.layout')

@section('user.content')
<div class="bg-white rounded-md dark:bg-gray-700">
    <div class="w-full p-4 border-b border-gray-200 ">
        <p class="font-bold dark:text-gray-200">
            User Security Settings
        </p>
    </div>
    <div class="p-4">
        <section>
            <p class="font-bold dark:text-gray-200 mb-3">
                Multifactor Authentication
            </p>
            @if (session('status') == 'two-factor-authentication-enabled')
                <div class="bg-green-400 bg-opacity-20 text-green-700 border-l-4 border-green-400 py-3 px-4 dark:bg-opacity-40 dark:text-green-400">
                    <i class="fas fa-check-circle mr-1"></i> Two factor authentication has been enabled.
                </div>    
            @endif

            @if (session('status') == 'two-factor-authentication-disabled')
                <div class="bg-blue-400 bg-opacity-20 text-blue-700 border-l-4 border-blue-400 py-3 px-4 dark:bg-opacity-40 dark:text-blue-300">
                    <i class="fas fa-info-circle mr-1"></i> Two factor authentication has been disabled.
                </div>
            @endif

            <form action="/user/two-factor-authentication" method="POST" class="mt-3">
                @csrf
                @if (Auth::user()->get2faEnabled())

                @else
                    <p class="mb-5 dark:text-gray-200">
                        2FA is currently disabled
                    </p>
                    <button type="sutmit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-600 text-white hover:bg-green-500">
                        Enable
                    </button>
                @endif
            </form>
        </section>
    </div>
</div>
@endsection