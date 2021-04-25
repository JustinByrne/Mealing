@extends('layouts.app')

@section('content')
    <div class="flex flex-col lg:flex-row lg:space-x-6">
        <div class="w-full lg:w-4/5 order-2 lg:order-1">
            <div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700 h-full">
                @yield('admin.content')
            </div>
        </div>
        <div class="w-full lg:w-1/5 order-1 mb-3 lg:mb-0" x-data="{open: false}">
            <div class="w-full rounded-md shadow-md bg-white dark:bg-gray-700">
                <div class="flex justify-between p-4 border-b border-gray-200">
                    <p class="font-bold dark:text-gray-200 self-center">
                        Admin Menu
                    </p>
                    <div class="lg:hidden">
                        <button class="border border-gray-100 px-2 pt-1 rounded-lg dark:text-gray-200" @click="open = !open">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="hidden lg:block" :class="{'hidden': !open}">
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <div class="font-bold mb-3 dark:text-gray-200">
                                Users
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <a href="{{ route('admin.users.index') }}" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - List all Users
                            </a>
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - Create new User
                            </a>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <div class="font-bold mb-3 dark:text-gray-200">
                                Roles &amp; Permissions
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - List all Roles
                            </a>
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - Create new Role
                            </a>
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - List all Permissions
                            </a>
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - Create new Permission
                            </a>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex flex-row justify-between">
                            <div class="font-bold mb-3 dark:text-gray-200">
                                Ingredients
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - List all Ingredients
                            </a>
                            <a href="#" class="hover:text-yellow-600 dark:text-gray-200 dark:hover:text-yellow-600">
                                - Add new Ingredient
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection