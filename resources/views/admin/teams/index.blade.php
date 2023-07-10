<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-nav-link :href="route('admin.teams.index')" :active="request()->routeIs('admin.teams.index')">
                {{ __('All teams') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.teams.create')" :active="request()->routeIs('admin.teams.create')">
                {{ __('Create new team') }}
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
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Team Leader
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Project Leader
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Show</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($teams as $t)
                                <tr
                                    class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $t->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $t->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $t->tl_fn }} {{ $t->tl_fn }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $t->pl_fn }} {{ $t->pl_fn }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-nav-link :href="route('admin.teams.show', ['team' => $t->id])" :active="request()->routeIs('admin.teams.show')">
                                            {{ __('show') }}
                                        </x-nav-link>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 p-4">
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
