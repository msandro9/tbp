<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create permission') }} #{{ $permission->id }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Id: {{ $request->id }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Employee: {{ $request->first_name }} {{ $request->last_name }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Start date: {{ $request->start_date }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    End date: {{ $request->end_date }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Days: {{ $request->duration }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Created at: {{ $request->created_at }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    Status: {{ $request->status }}
                </div>
            </div>
        </div>
    </div>
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST"
                          action="{{ route('employee.permissions.update', ['request' => $request->id, 'permission' => $permission->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mt-4">
                            <fieldset id="accepted">
                                <div>
                                    <x-label for="true" :value="__('Accepted')" />
                                    <input type="radio" value="true" name="accepted" checked="checked">
                                </div>
                                <div>
                                    <x-label for="false" :value="__('Declined')" />
                                    <input type="radio" value="false" name="accepted">
                                </div>
                            </fieldset>
                        </div>
                        <div class="mt-4">
                            <x-label for="note" :value="__('Note')" />
                            <input type="text" name="note" id="note"
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
