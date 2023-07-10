<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit team') }} #{{ $t->id }} {{ $t->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors"/>

                    <form method="POST" action="{{ route('admin.teams.update', ['team' => $t->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')"/>
                            <input type="text" name="name" id="name"
                                   value="{{ $t->name }}"
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Team Leader-->
                        <div class="mt-4">
                            <x-label for="team_leader_id" :value="__('Team Leader')"/>

                            <select name="team_leader_id" id="team_leader_id" value="{{ $t->tl_id }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Select team leader</option>
                                </option>
                                @if(!empty($t->tl_id))
                                    <option selected value="{{ $t->tl_id }}">#{{ $t->tl_id }} {{ $t->tl_fn }} {{ $t->tl_ln }}
                                    </option>
                                @endif
                                @foreach ($employees as $e)
                                    <option value="{{ $e->id }}">#{{ $e->id }} {{ $e->first_name }} {{ $e->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Project Leader-->
                        <div class="mt-4">
                            <x-label for="project_leader_id" :value="__('Project Leader')"/>

                            <select name="project_leader_id" id="project_leader_id" value="{{ $t->pl_id }}"
                                    class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Select project leader</option>
                                </option>
                                @if(!empty($t->pl_id))
                                    <option selected value="{{ $t->pl_id }}">#{{ $t->pl_id }} {{ $t->pl_fn }} {{ $t->pl_ln }}
                                    </option>
                                @endif
                                @foreach ($employees as $e)
                                    <option value="{{ $e->id }}">#{{ $e->id }} {{ $e->first_name }} {{ $e->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Edit team') }}
                            </x-button>
                        </div>
                        <input name="team_id" type="hidden" value="{{ $t->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

