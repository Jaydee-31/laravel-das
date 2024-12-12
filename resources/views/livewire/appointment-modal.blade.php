<x-dialog-modal wire:model.live="openAppointmentModal">

    <x-slot name="title">
        {{ __('Appointment Details') }}
    </x-slot>

    <x-slot name="content">
        <div class="grid grid-cols-2">
            <div>
                <strong class="text-xs">Name: </strong>
                <p class="text-md mb-2">{{ $appointment->name }}</p>
                <strong class="text-xs">Phone: </strong>
                <p class="text-md mb-2">{{ $appointment->phone }}</p>
                <strong class="text-xs">Email: </strong>
                <p class="text-md mb-2">{{ $appointment->email }}</p>
                <strong class="text-xs">Address: </strong>
                <p class="text-md mb-2">{{ $appointment->address }}</p>
            </div>
            <div>
                <strong class="text-xs">Date: </strong>
                <p class="text-md mb-2">{{ $appointment->date->format('D M d, Y') }}</p>
                <strong class="text-xs">Time: </strong>
                <p class="text-md mb-2">{{ date('h:i A - ', strtotime($appointment->start_time)) . date('h:i A', strtotime($appointment->end_time))}}</p>
                <strong class="text-xs">Doctor: </strong>
                <p class="text-md mb-2">{{ $appointment->doctor->user->name }}</p>
            </div>
        </div>


        <div class="mt-4">
            <select wire:model.live="selectedStatus"
                    class="text-xs self-start font-medium py-1.5 rounded border border-blue-400 focus:ring-1 focus:ring-danger-600
                    {{ match($selectedStatus) {
                        'pending' => 'bg-amber-100 text-amber-800 border-amber-400 focus:ring-amber-100',
                        'confirmed' => 'bg-blue-100 text-blue-800 border-blue-400 focus:ring-blue-100',
                        'cancelled' => 'bg-rose-100 text-rose-800 border-rose-400 focus:ring-rose-100',
                        'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-400 focus:ring-emerald-100',
                        default => 'bg-gray',
                    } }}">
                ">
                <option class="bg-white text-gray-900" value="pending">Pending</option>
                <option class="bg-white text-gray-900" value="confirmed">Confirmed</option>
                <option class="bg-white text-gray-900" value="cancelled">Cancelled</option>
                <option class="bg-white text-gray-900" value="completed">Completed</option>
            </select>
            <x-input-error for="selectedStatus" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click.prevent="cancel()" wire:loading.attr="disabled">
            {{ __('Close') }}
        </x-secondary-button>
        {{--        <x-button wire:click.prevent="save()" class="ms-3">--}}
        {{--            Save--}}
        {{--        </x-button>--}}
    </x-slot>

</x-dialog-modal>
