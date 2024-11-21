<div>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Banners') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="col-md-8 mb-2">
                @if(session()->has('success'))
                <x-alert-top-right>
                    {{ session()->get('success') }}
                </x-alert-top-right>
                @endif
                @if(session()->has('error'))
                <x-alert>
                    {{ session()->get('error') }}
                </x-alert>
                @endif
            </div>

            <div class="flex justify-between">
                <x-button wire:click="openModal" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-button>
                <x-input wire:model.live="search" type="text" placeholder="Search vendors.." />
            </div>

            @include('livewire.banners.banner-form')

            <div class="col-md-8 mt-6">
                <div class="card">
                    <div class="overflow-hidden overflow-x-auto card-body mb-3">
                        <div class="table-responsive">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100 ">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                            Sizes
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($banners as $banner)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $banner->id }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                            {{ $banner->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                            {{ implode(', ', $banner->sizes) }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <x-edit-button x-on:click="$wire.openModal({{ $banner->id }})" class="mr-4 ">
                                                {{ __('Edit') }}
                                            </x-edit-button>
                                            <x-delete-button wire:click=" delete({{ $banner->id }})"
                                                wire:confirm="Are you sure you want to delete this record?" type="button" class="mr-2">
                                                Delete
                                            </x-delete-button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            No banners Found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
