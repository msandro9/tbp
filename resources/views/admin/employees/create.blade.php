<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.index')">
                {{ __('All employees') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.employees.create')" :active="request()->routeIs('admin.employees.create')">
                {{ __('Create new employee') }}
            </x-nav-link>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('admin.employees.store') }}">
                        @csrf

                        <!-- First Name -->
                        <div>
                            <x-label for="first_name" :value="__('First Name')" />

                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                     :value="old('first_name')" required autofocus />
                        </div>

                        <!-- Last Name -->
                        <div class="mt-4">
                            <x-label for="last_name" :value="__('Last Name')" />

                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                     :value="old('last_name')" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                     required />
                        </div>

                        <!-- Street -->
                        <div class="mt-4">
                            <x-label for="street" :value="__('Street')" />

                            <x-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street')"
                                     required />
                        </div>

                        <!-- Number -->
                        <div class="mt-4">
                            <x-label for="number" :value="__('Number')" />

                            <x-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')"
                                     required />
                        </div>

                        <!-- Postal Code -->
                        <div class="mt-4">
                            <x-label for="postal_code" :value="__('Postal code')" />

                            <x-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')"
                                     required />
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <x-label for="city" :value="__('City')" />

                            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')"
                                     required />
                        </div>

                        <!-- Country -->
                        <div class="mt-4">
                            <x-label for="country" :value="__('Country')" />

                            <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')"
                                     required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create new employee') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
