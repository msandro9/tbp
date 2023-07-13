<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as") }}
                    #{{ auth()->id() }} {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}.
                </div>
            </div>
        </div>
    </div>

    @if($notLeader)
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-nav-link :href="route('employee.requests.create')"
                            :active="request()->routeIs('employee.requests.create')">
                    <x-button>
                        {{ __('New request') }}
                    </x-button>
                </x-nav-link>
            </div>
        </div>

        <x-request-table title="Pending" :requests="$pendingRequests">

        </x-request-table>

        <x-request-table title="Approved" :requests="$approvedRequests">

        </x-request-table>

        <x-request-table title="Declined" :requests="$declinedRequests">

        </x-request-table>
    @else
        <x-request-table title="Pending team requests" :requests="$requests" :showUser="true" :finished="false">

        </x-request-table>
    @endif
</x-app-layout>
