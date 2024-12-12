<?php

namespace App\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class AppointmentModal extends Component
{
    public $event;
    public $showModal = false;

    public $search = '';
    public $openAppointmentModal = false;
    public $isEditMode = false;

    public function openModal(?int $bannerId = null): void
    {
        $this->openAppointmentModal = true;
    }

    protected $listeners = ['openEventModal'];

    public function openEventModal($eventId)
    {
        $this->event = Appointment::find($eventId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.appointment-modal');
    }
}
