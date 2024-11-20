
<x-dialog-modal wire:model.live="openCountryModal">

    <x-slot name="title">
        {{ $isEditMode ? 'Edit Country' : 'Add Country' }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="">
                    <div class="overflow-hidden">
                        <div class="pt-3">

                            <div class=" py-3 sm:py-3">
                                <x-label for="countryName">Name</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.name" placeholder="Enter Name" autofocus/>
                                <x-input-error for="title" class="mt-1" />
                                <x-input-error for="form.name" class="mt-2" />
                            </div>

                            <div class=" py-3 sm:py-3">
                                <x-label for="countryCode">Code</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.code" placeholder="Enter Code" autofocus/>
                                <x-input-error for="title" class="mt-1" />
                                <x-input-error for="form.code" class="mt-2" />
                            </div>

                            <div class=" py-3 sm:py-3">
                                <x-label for="countryLanguageCode">Language Code</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.language_code" placeholder="Enter Language Code" autofocus/>
                                <x-input-error for="title" class="mt-1" />
                                <x-input-error for="form.language_code" class="mt-2" />
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click.prevent="cancel()" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>
        <x-button wire:click.prevent="save()" class="ms-3">
            {{ $isEditMode ? 'Update' : 'Save' }}
        </x-button>
    </x-slot>
</x-dialog-modal>
