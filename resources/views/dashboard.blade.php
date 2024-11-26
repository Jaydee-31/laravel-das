<x-app-layout>
    <div>
        <header class="">
            <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
                <div class="flex justify-between">
                    <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Calendar') }}
                    </h2>
                </div>
            </div>
        </header>

        <div class="">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <livewire:appointments-calendar
                    before-calendar-view="vendor/livewire-calendar/header-action"
                />
            </div>
        </div>
</x-app-layout>
