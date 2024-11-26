<div>
    <header class="">
        <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
            <div class="flex justify-between">
                <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('List of Appointments') }}
                </h2>
                <div class="">
                    {{ $this->createAction }}
                </div>
            </div>
        </div>
    </header>

    <div class="">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">

            <x-filament-actions::modals/>

            {{ $this->table }}
        </div>
    </div>
</div>
