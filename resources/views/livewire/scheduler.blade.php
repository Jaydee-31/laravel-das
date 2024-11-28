<?php

use App\Models\Appointment;
use App\Models\Banner;
use App\Models\Country;
use App\Models\Vendor;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Contracts\HasActions;
use Livewire\Attributes\Validate;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Livewire\Volt\Component;

new class extends Component implements HasForms, HasActions {

    use InteractsWithForms;
    use InteractsWithActions;

    public Appointment $appointment;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function createAction(): Action
    {
        return \Filament\Actions\CreateAction::make()
            ->label('Schedule Appointment Now')
            ->model(Appointment::class)
            ->form(app(\App\Livewire\AppointmentList::class)->appointmentForm())
            ->mutateFormDataUsing(function (array $data): array {
                $data['added_by_id'] = 1;
                return $data;
            })
            ->createAnother(false);
    }

} ?>

<div>
    {{ $this->createAction }}
    <x-filament-actions::modals/>
</div>
