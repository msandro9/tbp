<section>
    <header>
        @if ($user->picture)
            <div class="p-6 bg-white border-b border-gray-200">
                <img src="data:image;base64,{{ $e->picture }}" alt="employee picture"
                     class="w-16 h-16 rounded-full">
            </div>
        @endif
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    class="text-sm text-green-600"
                >{{ __('Successfully saved.') }}</p>
            @endif
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('employee.profile.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-label for="picture" :value="__('Picture')"/>

            <input id="picture" class="block mt-1 w-full" type="file" name="picture" accept="image/*" />
        </div>

        <!-- First Name -->
        <div class="mt-4">
            <x-label for="first_name" :value="__('First Name')"/>

            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                     :value="old('first_name') ?? $user->first_name" required autofocus/>
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-label for="last_name" :value="__('Last Name')"/>

            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                     :value="old('last_name')  ?? $user->last_name" required autofocus/>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email" :value="__('Email')"/>

            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email') ?? $user->email"
                     required/>
        </div>

        <!-- Street -->
        <div class="mt-4">
            <x-label for="street" :value="__('Street')"/>

            <x-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street') ?? $user->street"
                     required/>
        </div>

        <!-- Number -->
        <div class="mt-4">
            <x-label for="number" :value="__('Number')"/>

            <x-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number') ?? $user->number"
                     required/>
        </div>

        <!-- Postal Code -->
        <div class="mt-4">
            <x-label for="postal_code" :value="__('Postal code')"/>

            <x-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code"
                     :value="old('postal_code') ?? $user->postal_code"
                     required/>
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-label for="city" :value="__('City')"/>

            <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city') ?? $user->city"
                     required/>
        </div>

        <!-- Country -->
        <div class="mt-4">
            <x-label for="country" :value="__('Country')"/>

            <x-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')  ?? $user->country"
                     required/>
        </div>

        <div class="flex items-center gap-4">
            <x-button>{{ __('Save') }}</x-button>
        </div>
    </form>
</section>
