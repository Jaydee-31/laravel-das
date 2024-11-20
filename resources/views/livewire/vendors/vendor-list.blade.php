<div>
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
    <div>
        <div class="flex justify-between">
            <x-button wire:click="openModal" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-button>
            <x-input wire:model.live="search" type="text" placeholder="Search vendors.." />
        </div>

        @if($updateVendor)
        @include('livewire.vendors.update')
        @else
        @include('livewire.vendors.create')
        @endif

        <div class="col-md-8 mt-6">
            <div class="card">
                <div class="overflow-hidden overflow-x-auto card-body mb-3">
                    <div class="table-responsive">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 w-full">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">
                                        Description
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider dark:text-gray-100">

                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 dark:bg-opacity-50 divide-y divide-gray-200 dark:divide-gray-700">

                                @forelse($vendors as $vendor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $vendor->id }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                        {{ $vendor->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white max-w-xs overflow-ellipsis truncate">
                                        {{ $vendor->description }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="edit({{$vendor->id}})" class="text-blue-600 dark:text-blue-500 hover:text-blue-900 mr-4 ">Edit</button>
                                        <button wire:click="destroy({{$vendor->id}})"
                                            wire:confirm="Are you sure you want to delete this record?" type="button" class="text-red-600 dark:text-red-400 hover:text-red-900 cursor-pointer mr-2">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 dark:text-white text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                        No Vendors Found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $vendors->links() }}
            </div>
        </div>
    </div>
</div>