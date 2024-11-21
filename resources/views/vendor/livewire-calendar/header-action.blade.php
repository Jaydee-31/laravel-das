<div class="flex content-center justify-between mb-3">
    <div class="flex">
        <!-- Add Livewire click actions to buttons -->
        <x-button wire:click="goToPreviousMonth" class="rounded-e-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </x-button>
        <x-button wire:click="goToNextMonth" class="rounded-s-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </x-button>
        @if(!$this->startsAt->isSameMonth(Carbon\Carbon::today()))
            <x-secondary-button
                wire:click="goToCurrentMonth"
                class="ml-3">
                Today
            </x-secondary-button>
        @endif
    </div>
    <div class="text-xl font-semibold">{{ $this->startsAt->format('F Y') }}</div>
</div>
