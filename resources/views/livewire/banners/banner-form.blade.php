
<x-dialog-modal wire:model.live="openBannerModal">

    <x-slot name="title">
        {{ $isEditMode ? 'Edit Banner' : 'Add Banner' }}
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="">
                <div class="">
                    <div class="overflow-hidden">
                        <div class="pt-3">

                            <div class=" py-3 sm:py-3">
                                <x-label for="bannerName">Name</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.name" placeholder="Enter Name" autofocus/>
                                <x-input-error for="form.name" class="mt-2" />
                            </div>

                            <div class=" py-3 sm:py-3">
                                <x-label for="bannerSizes">Sizes (comma-separated)</x-label>
                                <x-input class="block mt-1 w-full" type="text" wire:model="form.sizes" placeholder="510x170, 1200x628"></x-input>
                                <x-input-error for="form.sizes" class="mt-2" />
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
