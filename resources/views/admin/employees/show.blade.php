<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee') }} #{{ $e->id }} {{ $e->first_name }} {{ $e->last_name }}
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
                    Id: {{ $e->id }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Role: {{ $e->role }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    First name: {{ $e->first_name }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Last name: {{ $e->last_name }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Email: {{ $e->email }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Address: {{ $e->address }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Team: {!! !empty($e->team_name) ? $e->team_name : 'null' !!}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Vaction days: {{ $e->vacation_days }}
                </div>

            </div>
            <x-nav-link :href="route('admin.employees.edit', ['employee' => $e->id])" :active="request()->routeIs('admin.employees.edit')">
                {{ __('Edit user') }}
            </x-nav-link>
            <x-nav-link>
                <form method="POST" action={{ route('admin.employees.destroy', ['employee' => $e->id]) }}>
                    @csrf
                    @method('DELETE')
                    <button>Delete user</button>
                </form>
            </x-nav-link>
        </div>
    </div>
</x-app-layout>
