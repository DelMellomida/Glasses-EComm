<x-form-section submit="saveProfile">

    <x-slot name="title">
        {{ __('User Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information.') }}
    </x-slot>

    <x-slot name="form">   
        <!-- Address -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="address" value="{{ __('Address') }}" />
            <x-input id="address" type="text" class="mt-1 block w-full" wire:model="state.address" required autocomplete="address"/>
            <x-input-error for="address" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone_number" value="{{ __('Phone Number') }}" />
            <x-input id="phone_number" type="text" class="mt-1 block w-full" wire:model="state.phone_number" required autocomplete="phone_number" />
            <x-input-error for="phone_number" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="gender" value="{{ __('Gender') }}" />
    
            <select id="gender" class="mt-1 block w-full rounded-md" wire:model="state.gender" required autocomplete="gender">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <x-input-error for="gender" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
            <x-input id="date_of_birth" type="date" class="mt-1 block w-full" wire:model="state.date_of_birth" required autocomplete="date_of_birth"/>
            <x-input-error for="date_of_birth" class="mt-2" />
        </div>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>

    </x-slot>

</x-form-section>

