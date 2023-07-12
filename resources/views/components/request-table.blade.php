<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(!empty($title))
            {{ $title }}
        @endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6 bg-white border-b border-gray-200">
                @if(empty($requests))
                    0 results.
                @else
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Id
                                </th>
                                @if($showUser)
                                    <th scope="col" class="px-6 py-3">
                                        Employee
                                    </th>
                                @endif
                                <th scope="col" class="px-6 py-3">
                                    Start date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    End date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Duration
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created at
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Show</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($requests as $r)
                                <tr
                                    class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $r->id }}
                                    </th>
                                    @if($showUser)
                                        <td class="px-6 py-4">
                                            #{{ $r->employee_id }} {{ $r->first_name }} {{ $r->last_name }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4">
                                        {{ $r->start_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $r->end_date }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $r->duration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $r->created_at }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-nav-link :href="route('employee.requests.show', ['request' => $r->id])"
                                                    :active="request()->routeIs('employee.requests.show')">
                                            {{ __('show') }}
                                        </x-nav-link>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
