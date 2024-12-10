<div>
    <header class="">
        <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
            <div class="">
                {{ $this->doctorAppointmentInfolist }}
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
