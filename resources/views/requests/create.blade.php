<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create new request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('employee.requests.store') }}">
                        @csrf
                        You have {{ $vacation_days }} vacation days remaining.
                        <!-- Start date -->
                        <div class="mt-4">
                            <x-label for="start_date" :value="__('Start date')" />

                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                   required
                                   class="
                                block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                        <!-- End date -->
                        <div class="mt-4">
                            <x-label for="end_date" :value="__('End date')" />

                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Create new request') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
