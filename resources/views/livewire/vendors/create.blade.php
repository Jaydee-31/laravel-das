
 <x-dialog-modal wire:model.live="openingModal">

    <x-slot name="title">
        Add Vendor
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="">
                    <div class="overflow-hidden">
                        <div class="pt-3">
                            <div class=" py-3 sm:py-3">
                                <x-label for="vendorName">Name</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="name" placeholder="Enter Name" autofocus/>
                                <x-input-error for="name" class="mt-1" />
                            </div>

                            <div class=" py-3 sm:py-3">
                                <x-label for="vendorDescription">Description</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="description" placeholder="Enter Description"></x-input>
                                <x-input-error for="description" class="mt-1" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('openingModal')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>
        <x-button wire:click.prevent="store()" class="ms-3">
                {{ __('Save') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
