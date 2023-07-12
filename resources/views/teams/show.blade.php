<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team') }} #{{ $t->id }} {{ $t->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{--}}
            <x-nav-link :href="route('admin.users.show.requests', ['user' => $user])" :active="request()->routeIs('admin.users.show.requests')">
                {{ __('Requests') }}
            </x-nav-link>
            {{--}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Id: {{ $t->id }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Team Leader: #{{ $t->tl_id }} {{ $t->tl_fn }} {{ $t->tl_ln }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Project Leader: #{{ $t->pl_id }} {{ $t->pl_fn }} {{ $t->pl_ln }}
                </div>
            </div>
{{--            <x-nav-link :href="route('admin.teams.edit', ['team' => $t->id])" :active="request()->routeIs('admin.teams.edit')">
                {{ __('Edit team') }}
            </x-nav-link>
            <x-nav-link>
                <form method="POST" action={{ route('admin.teams.destroy', ['team' => $t->id]) }}>
                    @csrf
                    @method('DELETE')
                    <button>Delete team</button>
                </form>
            </x-nav-link>--}}


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
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
                </div>
            </div>
        </div>
        <x-request-table title="Upcoming vacations" :requests="$upcoming" :showUser="true">

        </x-request-table>
    </div>
</x-app-layout>