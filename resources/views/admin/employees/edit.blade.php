<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit employee') }} #{{ $e->id }} {{ $e->first_name }} {{ $e->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('admin.employees.update', ['employee' => $e->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Vacation days -->
                        <div class="mt-4">
                            <x-label for="vacation_days" :value="__('Vaction days')"/>
                            <input type="number" name="vacation_days" id="vacation_days"
                                   value="{{ $e->vacation_days }}"
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Team -->
                        <div class="mt-4">
                            <x-label for="team_id" :value="__('Select team')"/>

                            <select name="team_id" id="team_id" value="{{ $e->team_id }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Select team</option>
                                </option>
                                @foreach ($teams as $t)
                                    @if ($e->team_id == $t->id)
                                        <option selected value="{{ $t->id }}">#{{ $t->id }}
                                            {{ $t->name }}
                                        </option>
                                    @else
                                        <option value="{{ $t->id }}">#{{ $t->id }} {{ $t->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Edit employee') }}
                            </x-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

