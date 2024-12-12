<x-dialog-modal wire:model.live="openAppointmentModal">

    <x-slot name="title">
        {{ __('Appointment Details') }}
    </x-slot>

    <x-slot name="content">
        <h2 class="text-lg font-bold">{{ $appointment->name }}</h2>
        <p><strong>Phone: </strong>{{ $appointment->phone }}</p>
        <p><strong>Email: </strong>{{ $appointment->email }}</p>
        <p><strong>Address: </strong>{{ $appointment->address }}</p>
        <p><strong>Date: </strong> {{ $appointment->date->format('D M d, Y') }}</p>
        <p><strong>Doctor: </strong> {{ $appointment->doctor->user->name }}</p>
        <p><strong>Status: </strong> {{ $appointment->status }}</p>
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
