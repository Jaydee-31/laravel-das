<div>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Countries') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="col-md-8 mb-2">
                @if(session()->has('success'))
                    <x-alert>
                        {{ session()->get('success') }}
                    </x-alert>
                @endif
                @if(session()->has('error'))
                    <x-alert>
                        {{ session()->get('error') }}
                    </x-alert>
                @endif
            </div>

            <x-button wire:click="openModal" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-button>

            @include('livewire.countries.country-form')

            <div class="col-md-8 mt-6">
                <div class="card">
                    <div class="overflow-hidden overflow-x-auto card-body">
                        <div class="table-responsive">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100 ">
                                        Sales Org
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                        Country Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                        Language Code
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">

                                    </th>
                                </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($countries as $country)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $country->code }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                            {{ $country->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                            {{ $country->language_code }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button x-on:click="$wire.openModal({{ $country->id }})" class="text-blue-600 dark:text-blue-500 hover:text-blue-900 mr-4 ">Edit</button>
                                            <button wire:click="delete({{ $country->id }})"
                                                    wire:confirm="Are you sure you want to delete this record?" type="button" class="text-red-600 dark:text-red-400 hover:text-red-900 cursor-pointer mr-2"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            No countrys Found.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
