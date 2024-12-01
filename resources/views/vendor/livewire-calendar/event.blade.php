<div
    @if($eventClickEnabled)
        wire:click.stop="onEventClick('{{ $event['id']  }}')"
    @endif
    class="bg-white rounded-lg border py-2 px-3 shadow-sm cursor-pointer">

    <p class=" text-sm font-medium">
        {{ $event['title'] }}
    </p>
    <div class="flex items-center gap-[5px] mt-1">
        <div class="h-2 w-2 rounded-full
        {{ match($event['status']) {
            'pending' => 'bg-amber-500',
            'confirmed' => 'bg-blue-500',
            'cancelled' => 'bg-rose-500',
            'completed' => 'bg-emerald-500',
            default => 'bg-gray',
        } }}">

        </div>
        <p class="text-xs">
            {{ $event['description'] ?? 'No description' }}
        </p>
    </div>
</div>
