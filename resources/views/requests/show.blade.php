<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request') }} #{{ $request->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Id: {{ $request->id }}
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    User: {{ $request->first_name }} {{ $request->last_name }}
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
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Team leader permission
                    </h2>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Status: @if($teamLeaderPermission->accepted === true)
                        {{'Accepted'}}
                    @elseif($teamLeaderPermission->accepted === false)
                        {{'Declined'}}
                    @else
                        {{'Pending'}}
                    @endif
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Note: {{$teamLeaderPermission->note}}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Date: @if($teamLeaderPermissionNotUpdated)
                        {{''}}
                    @else
                        {{$teamLeaderPermission->updated_at}}
                    @endif
                </div>
            </div>

            @if($isTeamLeader && $teamLeaderPermissionNotUpdated && $request->status = \App\Models\RequestStatus::PENDING)
                <div class="flex items-center justify-start mt-4">
                    <a
                        href="{{ URL::route('employee.permissions.edit', ['request' => $request->id, 'permission' => $teamLeaderPermission->id]) }}">
                        <x-button class="ml-4">
                            {{ __('Accept/Decline') }}
                        </x-button>
                    </a>
                </div>
            @endif
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Project leader permission
                    </h2>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Status: @if($projectLeaderPermission->accepted === true)
                        {{'Accepted'}}
                    @elseif($projectLeaderPermission->accepted = false)
                        {{'Declined'}}
                    @else
                        {{'Pending'}}
                    @endif
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Note: {{ $projectLeaderPermission->note}}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Date: @if($projectLeaderPermissionNotUpdated)
                        {{''}}
                    @else
                        {{$projectLeaderPermission->updated_at}}
                    @endif
                </div>
            </div>
            @if($isProjectLeader && $projectLeaderPermissionNotUpdated && $request->status = \App\Models\RequestStatus::PENDING)
                <div class="flex items-center justify-start mt-4">
                    <a
                        href="{{ URL::route('employee.permissions.edit', ['request' => $request->id, 'permission' => $projectLeaderPermission->id]) }}">
                        <x-button class="ml-4">
                            {{ __('Accept/Decline') }}
                        </x-button>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
