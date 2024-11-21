<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vendors') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('vendor-list')
        </div>
    </div>
</x-app-layout>
