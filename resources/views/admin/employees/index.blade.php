<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
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

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Id
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Address
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Team
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Vacation days
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Show</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $e)
                                <tr
                                    class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $e->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @if ($e->picture)
                                            <img src="data:image;base64,{{ $e->picture }}" alt="employee picture" class="w-16 h-16 rounded-full">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->first_name }} {{ $e->last_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->role ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->address ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->team_name ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $e->vacation_days }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-nav-link :href="route('admin.employees.show', ['employee' => $e->id])" :active="request()->routeIs('admin.employees.show')">
                                            {{ __('show') }}
                                        </x-nav-link>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 p-4">
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
