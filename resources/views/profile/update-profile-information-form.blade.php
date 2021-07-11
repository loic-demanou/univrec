<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                        x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>


        @if (auth()->user()->role_id == 1)

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="presentation" value="{{ __('presentation (brief introduction)') }}" />
                <x-jet-input id="presentation" type="text" class="mt-1 block w-full"
                    wire:model.defer="state.presentation" value="{{ Auth::user()->title }}" />
                <x-jet-input-error for="presentation" class="mt-2" />
            </div>
            

                {{-- <x-jet-input id="description" type="text" class="mt-1 block w-full" value="{{ Auth::user()->title }}" /> --}}

                {{-- <x-jet-input-error for="description" class="mt-2" /> --}}

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('description (brief introduction)') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full"
                        wire:model.defer="state.description" value="{{ Auth::user()->description }}" />
                    <x-jet-input-error for="description" class="mt-2" />
                </div>
    

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="rate" value="{{ __('Rate/hour') }}" />
                <x-jet-input id="rate" type="number" class="mt-1 block " wire:model.defer="state.rate"
                    value="{{ Auth::user()->rate }}" />
                <x-jet-input-error for="rate" class="mt-2" />
            </div>
            <x-jet-input-error for="rate" class="mt-2" />


        @endif

        @if (auth()->user()->role_id == 2)

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="phone" value="{{ __('Phone number') }}" />
                <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone"
                    value=" !empty()" />
                <x-jet-input-error for="phone" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="fax" value="{{ __('fax') }}" />
                <x-jet-input id="fax" type="text" class="mt-1 w-full " wire:model.defer="state.fax"
                    value="" />
                <x-jet-input-error for="fax" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="postal_address" value="{{ __('postal_address (PO.Box)') }}" />
                <x-jet-input id="postal_address" type="text" class="mt-1 w-full "
                    wire:model.defer="state.postal_address" value="" />
                <x-jet-input-error for="postal_address" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="decrees_establishing" value="{{ __('decrees_establishing') }}" />
                <x-jet-input id="decrees_establishing" type="text" class="mt-1 w-full "
                    wire:model.defer="state.decrees_establishing"
                    value="" />
                <x-jet-input-error for="decrees_establishing" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="authorization_to_open" value="{{ __('authorization_to_open') }}" />
                <x-jet-input id="authorization_to_open" type="text" class="mt-1 w-full "
                    wire:model.defer="state.authorization_to_open"
                    value="" />
                <x-jet-input-error for="authorization_to_open" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="web_site" value="{{ __('web_site') }}" />
                <x-jet-input id="web_site" type="text" class="mt-1 w-full " wire:model.defer="state.web_site"
                    value="" />
                <x-jet-input-error for="web_site" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="location" value="{{ __('Location') }}" class="text-2xl" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="state" value="{{ __('state') }}" />
                <x-jet-input id="state" type="text" class="mt-1 w-full " wire:model.defer="state.state"
                    value="" />
                <x-jet-input-error for="state" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="region" value="{{ __('region') }}" />
                <x-jet-input id="region" type="text" class="mt-1 w-full " wire:model.defer="state.region"
                    value="" />
                <x-jet-input-error for="region" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="department" value="{{ __('department') }}" />
                <x-jet-input id="department" type="text" class="mt-1 w-full " wire:model.defer="state.department"
                    value="" />
                <x-jet-input-error for="department" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="location_site" value="{{ __('location_site') }}" />
                <x-jet-input id="location_site" type="text" class="mt-1 w-full " wire:model.defer="state.location_site"
                    value="" />
                <x-jet-input-error for="location_site" class="mt-2" />
            </div>



        @endif


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>