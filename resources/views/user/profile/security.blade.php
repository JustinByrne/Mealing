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
                    @method('DELETE')
                    <div x-data="{ isOpen: false }">
                        <button type="button" @click="isOpen = true" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                            <i class="fas fa-qrcode"></i> Show QR Code
                        </button>
                        <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full z-50" style="background-color: rgba(0,0,0,.5);" x-show="isOpen">
                        <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="isOpen = false">
                            <div class="flex items-center justify-between pb-6">
                                <h2 class="font-sans break-normal text-gray-900 text-base font-bold">QR Code</h2>
                                <span>
                                    <button @click="isOpen = false" type="button" class="flex-initial"><i class="fas fa-times"></i></button>
                                </span>
                            </div>
                            <div class="pb-3 px-4">
                                {!! Auth::user()->twoFactorQrCodeSvg() !!}
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-gray-400 text-white hover:bg-gray-300">
                        Disable
                    </button>
                    <div class="mt-4" x-data="{ isOpen: false }">
                        <div class="text-sm font-light leading-relaxed mt-0 mb-2 text-lightGray-800">
                            <p class="cursor-pointer hover:text-orange-500 hover:underline" @click="isOpen = true">Show Recovery Codes</p>
                        </div>
                        <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full z-50" style="background-color: rgba(0,0,0,.5);" x-show="isOpen">
                            <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" @click.away="isOpen = false">
                                <div class="flex items-center justify-between pb-6">
                                    <h2 class="font-sans break-normal text-gray-900 text-base font-bold">Recovery Codes</h2>
                                    <span>
                                        <button @click="isOpen = false" type="button" class="flex-initial"><i class="fas fa-times"></i></button>
                                    </span>
                                </div>
                                <div class="text-md font-light leading-relaxed mt-0 mb-2 px-4 text-lightGray-800">
                                    <ol class="list-decimal px-4 space-y-1">
                                        @foreach (Auth::user()->getRecoveryCodes() as $code)
                                            <li>{{ $code }}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="mb-5 dark:text-gray-200">
                        2FA is currently disabled
                    </p>
                    <button type="submit" class="w-full lg:w-auto rounded shadow-md py-2 px-4 bg-green-700 text-white hover:bg-green-500">
                        Enable
                    </button>
                @endif
            </form>
        </section>
    </div>
</div>
@endsection